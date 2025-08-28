

<?php
include  "connect.php";
// تعرض كل بيانات جددول categories
$alldata = array();
$alldata['status'] = "success";
$categories =  getAllData("categories" , null , null , false) ;

$alldata['categories'] = $categories ;

$items =  getAllData("items1view" , "items_discount!=0" , null , false) ;

$alldata['items'] = $items ;

echo json_encode($alldata);
?>