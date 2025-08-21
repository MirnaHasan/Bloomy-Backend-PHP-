
<?php 

include "../connect.php" ;
$addressid = filterRequest("addressid") ;

getAllData("address" , "address_usersid = $addressid") ;