<?php 
include "../connect.php" ; 
$usersid = filterRequest("usersid") ;
$addressid = filterRequest("addressid") ;
$ordertype = filterRequest("ordertype") ;
$orderpayment = filterRequest("orderpayment") ;
$couponid = filterRequest("couponid") ;
$orderprice = filterRequest("orderprice") ;
$orderpricedelivery = filterRequest("orderpricedelivery") ;
$orderprice = filterRequest("orderprice") ;
$discountcoupon = filterRequest("discountcoupon") ;
$totalprice = $orderprice + $orderpricedelivery ;
 // check coupon 
 $now = date('Y-m-d H:i:s') ;  

 $checkcoupon=getData("coupon" ,"coupon_id = '$couponid' AND coupon_expirdate > '$now' AND coupon_count > 0 " ,null ,false) ;
if ($checkcoupon > 0){
    $totalprice =  $totalprice - ($orderprice * $discountcoupon /100); 

}

$data = array (
    "orders_usersid"         => $usersid ,
    "orders_address"         => $addressid , 
    "orders_type"            => $ordertype  , 
    "orders_paymentmethod"   => $orderpayment  , 
    "orders_coupon"          => $couponid , 
    "orders_price"           => $orderprice ,
    "orders_totalprice"     => $totalprice ,
    "orders_pricedelivery"   => $orderpricedelivery  ,  
    "discountcoupon"=> $discountcoupon

) ; 
 $count =  insertData("orders" , $data , false) ; 
 if ($count > 0 ){

    $stmt = $con ->prepare("SELECT MAX(orders_id) FROM orders ") ; 

    $stmt->execute() ; 
    $maxorderid = $stmt->fetchColumn() ; 

$data = array(
    "cart_orders" => $maxorderid
) ;

    updateData("cart" , $data , "cart_usersid = $usersid  AND cart_orders = 0 ") ; 


 }