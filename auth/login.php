

<?php 
include "../connect.php";

$email = filterRequest("email") ; 
$password = sha1(filterRequest("password"));

$stmt = $con->prepare("SELECT * FROM users WHERE users_email =? AND users_password =?");
$stmt->execute(array($email , $password));
$count = $stmt->rowCount() ; 

Result($count);