<?php
include "../connect.php" ; 
 $usersid = filterRequest("usersid") ; 
 $addressid = filterRequest("addressid") ;
 
 $orderstype = filterRequest("ordertype") ; 
 $pricedelivery= filterRequest("orderpricedelivery") ;
 $ordersprice = filterRequest("orderprice") ;
 $couponid = filterRequest("couponid") ; 
 $paymentmethod = filterRequest("orderpayment") ; 
$discountcoupon =  filterRequest( "discountcoupon") ; 
if ($orderstype == "1"){
    $pricedelivery = 0 ; 

}
$totalprice = $pricedelivery + $ordersprice ; 

 //Check coupon 
 $now = date('Y-m-d H:i:s') ;  

   $checkcoupon =getData("coupon" , "coupon_id = '$couponid' AND coupon_expirdate > '$now' AND coupon_count > 0" ,null ,  false) ;
   if ($checkcoupon > 0){
  $totalprice = $totalprice - $ordersprice *$discountcoupon /100 ; 

  $stmt = $con->prepare("UPDATE `coupon` SET `coupon_count`= `coupon_count`-1 WHERE coupon_id = $couponid ") ;

  $stmt->execute() ; 
  


   }

 $data = array (
"orders_usersid" => $usersid , 
 "orders_address"=> $addressid , 
// "orders_address"      => ($orderstype == "1" ? null : $addressid), 
"orders_type"=>$orderstype , 
"orders_pricedelivery" => $pricedelivery , 
"orders_price"=> $ordersprice , 
"orders_coupon" => $couponid , 
"orders_paymentmethod"=>$paymentmethod , 
"orders_totalprice" => $totalprice , 

);
$count =insertData("orders" , $data , false) ;

if ($count > 0){
    $stmt = $con->prepare("SELECT MAX(orders_id) FROM  orders") ; 
    $stmt->execute() ; 
    $maxid = $stmt->fetchColumn() ; 
    $data = array("cart_orders" => $maxid) ; 
    updateData("cart" , $data ,"cart_usersid =$usersid AND cart_orders= 0") ; 
}