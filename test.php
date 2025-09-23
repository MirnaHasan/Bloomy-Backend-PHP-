
 <?php



include "connect.php" ; 
//  sendFCMTopic("اختبار إشعار", "هذه رسالة تجريبية من PHP", "all-users"); 
sendFCMTopic("hi"  , "How Are You" , "users" , "" , "") ; 

  echo "send" ;
?> 
