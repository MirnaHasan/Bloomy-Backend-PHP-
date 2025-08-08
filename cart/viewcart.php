<?php 
include "../connect.php" ; 
$userid = filterRequest("userid") ;
$itemsid = filterRequest("itemsid") ; 

getAllData("cart","cart_usersid = $userid  AND  cart_itemsid = $itemsid" ) ;
?>