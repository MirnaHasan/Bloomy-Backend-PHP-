

<?php
include "../connect.php" ; 
$userid = filterRequest("userid") ;
$itemsid = filterRequest("itemsid") ; 
 

deleteData("cart" , "cart_id = (SELECT * FROM cart WHERE cart_userid = $userid AND cart_itemsid = $itemsid LIMIT 1)") ;



   

?>