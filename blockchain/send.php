<?php

include ('c.php');
session_start();
$usersession= $_SESSION["name_login"];
$linkToMessageDepo="http://localhost:80/phpmyadmin/messagedepo";

$insertDate= date("Y-m-d H:i:s");

if (isset($_POST["reciver"]) and isset($_POST["message"]) ) {
    
    $reciver=$_POST["reciver"];
    $message=$_POST["message"];
    $sqlInsertMessage= "INSERT INTO message_depo (message,reciver) VALUES('" . $message . "','" . $reciver . "')";
    $sqlInsertInUserTable="INSERT INTO ".$reciver." (date,object,sender,reciver) VALUES ('". $insertDate."','" . $linkToMessageDepo . "','" . $usersession . "','" . $reciver . "') ";
    $insertMessageInMessageDepo=mysqli_query(connectToUserDate($usersession),$sqlInsertMessage);
    if ($insertMessageInMessageDepo) {
        
         $insertLinkInContact=mysqli_query(connectToUserDate($usersession),$sqlInsertInUserTable);
         if ($insertLinkInContact) {
             echo("insert perfectly");
         }else {
             echo("something went wrong");
         }
        
    }


}




?>