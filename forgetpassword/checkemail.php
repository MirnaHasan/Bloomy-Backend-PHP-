

<?php 
include "../connect.php";
$email = filterRequest("email"); 
$verfiycode = rand(10000 , 99999) ;
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();
// Result($count);
if ($count>0){

$data = array("users_verfiycode"=> $verfiycode);
updateData("users",$data , "users_email= '$email'" , false);
  // sendEmail($email , "VerfiyCode bloomy" , "verfiy code $verfiycode ") ;


}