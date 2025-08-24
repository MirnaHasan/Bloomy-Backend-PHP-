
<?php 

include "../connect.php" ;
$addressuserid = filterRequest("addressuserid") ;

getAllData("address" , "address_usersid = $addressuserid ") ;
/// عرض العناوين الخاصة ب مستخدم 