
<?php
include "../connect.php" ;
$username = filterRequest("username");
$email = filterRequest("email"); 
$password = sha1(filterRequest("password",PASSWORD_DEFAULT));
$phone = filterRequest("phone") ;
<<<<<<< HEAD
$verfiycode = rand(10000 , 999999) ;
=======
$verfiycode = rand(10000 , 99999) ;
>>>>>>> master

$stmt = $con->prepare("SELECT * From users WHERE  users_email =? OR users_phone = ?");
$stmt->execute(array($email,$phone));
$count = $stmt->rowCount();


if($count> 0){
printFailure("PHONE OR EMAIL ARE USED ALREADY");
   

}else {
$data = array(
    "users_name"           => $username,
    "users_email"          => $email,
    "users_password"       => $password ,
    "users_phone"          => $phone ,
    "users_verfiycode"     => $verfiycode );
    insertData("users", $data);
<<<<<<< HEAD
    sendEmail($email , "VerfiyCode bloomy" , "verfiy code $verfiycode ") ;
=======
    // sendEmail($email , "VerfiyCode bloomy" , "verfiy code $verfiycode ") ;
>>>>>>> master
}



?>