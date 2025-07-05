


<?php

// sendEmail("mirnamhasan50@gmail.com"  ,"Hi" , "i am mirna"  );

?>

<?php
include "connect.php";

$result = imageUpload("file");

if ($result['status'] == "success") {
    echo json_encode([
        "status" => "success",
        "filename" => $result['filename']
    ]);
} else {
    echo json_encode([
        "status" => "fail",
        "error" => $result['error']
    ]);
}
 
