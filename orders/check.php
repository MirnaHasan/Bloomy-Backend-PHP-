<?php 
include "../connect.php" ; 
$usersid = filterRequest("usersid") ;
$addressid = filterRequest("addressid") ;
$ordertype = filterRequest("ordertype") ;
$orderpayment = filterRequest("orderpayment") ;
$couponid = filterRequest("couponid") ;
$orderprice = filterRequest("orderprice") ;
$orderpricedelivery = filterRequest("orderpricedelivery") ;
$data = array (
    "orders_usersid"         => $usersid ,
    "orders_address"         => $addressid , 
    "orders_type"            => $ordertype  , 
    "orders_paymentmethod"   => $orderpayment  , 
    "orders_coupon"          => $couponid , 
    "orders_price"           => $orderprice ,
    "orders_pricedelivery"   => $orderpricedelivery  ,  

) ; 
 $count =  insertData("orders" , $data , false) ; 