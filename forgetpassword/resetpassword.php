


<?php
include "../connect.php";

$email = filterRequest("email");
$password = sha1(filterRequest("password")); // ملاحظ

$data = array("users_password" => $password);

// نمرر $email كـ شرط WHERE باستخدام whereParams
updateData("users", $data, "users_email = ?", [$email]);
