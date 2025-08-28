
<?php
include "../connect.php"; 

$email = filterRequest("email"); 

$verfiy = filterRequest("verfiycode");

$verfiy = filterRequest("verifycode");


// استخدم معاملات آمنة
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_verfiycode = ?");
$stmt->execute([$email, $verfiy]);

$count = $stmt->rowCount();

if ($count > 0) {
    $data = array("users_approve" => "1");

    // أيضًا تأكد أن قيمة $email تُستخدم داخل updateData بطريقة آمنة
    updateData("users", $data, "users_email = '$email'");
} else {
    printFailure("Verfiycode not correct");
}
?>
