<?php
define("MB", 1048576);

function filterRequest($requestname)
{
    return isset($_POST[$requestname]) ? htmlspecialchars(strip_tags($_POST[$requestname])) : '';
}

function getAllData($table, $where = null, $values = null, $json =true)
{
    global $con;
    $data = array();

    if ($where == null) {
         $stmt = $con->prepare("SELECT * FROM $table");
    } else {  
         $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    }
    $stmt->execute($values);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true){   
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count>0){
            return  array("status" => "success", "data" => $data) ;
        } else { 
            return array("status" => "failure");
        }
    }
}

function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    } else {
        return $count;
    }
}

    

function insertData($table, $data, $json = true)
{
    global $con;
    $ins = [];
    foreach ($data as $field => $v) {
        $ins[] = ':' . $field;
    }
    $insStr = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($insStr)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function updateData($table, $data, $where, $whereParams = [], $json = true)
{
    global $con;
    $cols = [];
    foreach ($data as $key => $val) {
        $cols[] = "`$key` = ?";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);

    // قيم التحديث + قيم شرط where معاً
    $values = array_values($data);
    if (!empty($whereParams)) {
        $values = array_merge($values, $whereParams);
    }

    $stmt->execute($values);
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }

    return $count;
}

function deleteData($table, $where, $values = [], $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute($values);
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest, $folder = "")
{
    define('MAX_FILE_SIZE', 6 * 1024 * 1024); 

    if (!isset($_FILES[$imageRequest])) {
        return ["status" => "fail", "error" => "No file uploaded"];
    }

    $file = $_FILES[$imageRequest];
    $imagename  = rand(1000, 10000) . "_" . basename($file['name']);
    $imagetmp   = $file['tmp_name'];
    $imagesize  = $file['size'];

    $allowedExt = ["jpg", "png", "gif", "mp3", "pdf", "svg"];
    $strToArray = explode(".", $imagename);
    $ext        = strtolower(end($strToArray));

    if (!in_array($ext, $allowedExt)) {
        return ["status" => "fail", "error" => "Invalid file extension"];
    }

    $uploadDir = __DIR__ . "/upload/$folder/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $imagename;

    if (move_uploaded_file($imagetmp, $uploadPath)) {
        return ["status" => "success", "filename" => $imagename];
    } else {
        return ["status" => "fail", "error" => "Failed to move uploaded file"];
    }
}

function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

function printFailure($message = "none")
{
    echo json_encode(array("status" => "failure" , "message" => $message));
}

function sendEmail($to, $title, $body)
{
    $header = "From: support@mirnahasan.com" . "\n" . "CC:mirnahasan1995@gmail.com";
    mail($to, $title, $body, $header);
   
}

function printSuccess($message = "none")
{
    echo json_encode(array("status" => "success" , "message" => $message));
}

function Result($count)
{
    if ($count > 0){
        printSuccess("success");
    } else {
        printFailure("failure");
    }
}
require __DIR__ . '/vendor/autoload.php';

function sendFCMTopic($title, $body, $topic , $pageid , $pagename) {
    $serviceAccountPath = __DIR__ . '/mybloomy-2f42b-firebase-adminsdk-fbsvc-d51abb83e8.json';
    $projectId = "mybloomy-2f42b";

    // إنشاء عميل Google
    $client = new Google\Client();
    $client->setAuthConfig($serviceAccountPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    // توليد Access Token
    $tokenArray = $client->fetchAccessTokenWithAssertion();
    if (!isset($tokenArray['access_token'])) {
        echo "خطأ في توليد التوكن:";
        print_r($tokenArray);
        return;
    }

    $accessToken = $tokenArray['access_token'];
    //  echo "Access Token (ضعه في Thunder Client):\n$accessToken\n\n";

    // رابط FCM
    $url = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

    //بناء الرسالة (التصحيح هنا 👇)
    $message = [
        "message" => [
            "topic" => $topic,
            "notification" => [
                "title" => $title,
                "body" => $body
            ],
            "data" => [
                "pageid" => $pageid,
                "pagename" => $pagename
            ],
            "android" => [
                "notification" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "sound" => "default"
                ]
            ],
        ]
        ];
   





    // إعداد headers
    $headers = [
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json"
    ];

    // إرسال الإشعار عبر cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // echo "HTTP Status: $httpcode\n";
    // echo "Response: $response\n";
}

?>

