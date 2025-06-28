

<?php
include  "connect.php";
// تعرض كل بيانات جددول categories
$alldata = array();
$categories =  getAllData("categories" , null , null , false) ;
$alldata['status'] = "success";
$alldata['categories'] = $categories ;

echo json_encode($alldata);
?>