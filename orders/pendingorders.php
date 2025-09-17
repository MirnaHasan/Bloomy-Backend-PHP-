
<?php
include "../connect.php" ; 
 $usersid = filterRequest("usersid") ; 
 getAllData("orders" , "orders_usersid = $usersid" , null , true ) ; 
 

//يستخد لعرض المنتجات التي تم طلبها و تححديها في عملية لشراء 