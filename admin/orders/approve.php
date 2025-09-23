

<?php
include "../../connect.php" ; 
$orderid = filterRequest("ordersid") ; 
$userid = filterRequest("usersid");


$data = array(
    "orders_status" => "1"
) ; 

// updateData("orders" , $data , "orders_id = $orderid AND orders_status =0") ;
updateData(
    "orders",
    $data,
    "orders_id = ? AND orders_status = 0",
    [$orderid] // ← تمرير قيمة ordersid بأمان
);

sendFCMTopic("Success"  , "Your Order Has Been Approved" , "users$userid" , "none" , "none") ; 