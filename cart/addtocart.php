
<?php
include "../connect.php" ; 
$userid = filterRequest("userid") ;
$itemsid = filterRequest("itemsid") ; 
$count = getData("cart" , "cart_usersid = $userid  AND  cart_itemsid = $itemsid" , null , false) ;

    $data = array(
        "cart_usersid" => $userid ,
        "cart_itemsid"=> $itemsid , 

    ) ; 
    insertData("cart" , $data) ;
//mysql create virtual table which calculate the numbers of items had added to cart 
//php if count> 0 update quantity else insert to cart table

?>