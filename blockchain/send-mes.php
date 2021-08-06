<?php
include ('c.php');
session_start();
$connect=mysqli_connect("localhost", "root", "");

$usersession= $_SESSION["name_login"];
$reciver =  $_POST['to_user_name'];
$message= $_POST['chat_message'];
$linkToMessageDepo="http://localhost:80/phpmyadmin/db_structure.php?server=1&db=".$usersession;
echo $reciver;
$insertDate= date("Y-m-d H:i:s");
$sqlGetMessageHistory = "SELECT * FROM ".$usersession.".message_depo WHERE reciver='".$reciver."' ORDER BY date DESC";

$sqlInsertMessage= "INSERT INTO message_depo (message,reciver,date) VALUES('" . $message . "','" . $reciver . "','". $insertDate."')";
$sqlInsertInUserTable="INSERT INTO ".$reciver." (date,object,sender,reciver) VALUES ('". $insertDate."','" . $linkToMessageDepo . "','" . $usersession . "','" . $reciver . "') ";
$insertMessageInMessageDepo=mysqli_query(connectToUserDate($usersession),$sqlInsertMessage);
$output = '<ul class="list-unstyled">';
$insertLinkInContact=mysqli_query(connectToUserDate($usersession),$sqlInsertInUserTable);  
 ///insert message //  $result =fetch_User_Data_History($usersession,$reciver); //  echo($result);
$getMessageHistoryFromDB=mysqli_query($connect,$sqlGetMessageHistory);
$resultGetMessageFromDB=mysqli_num_rows($getMessageHistoryFromDB);
$result=mysqli_fetch_assoc($getMessageHistoryFromDB);

if ($insertMessageInMessageDepo) {
  echo fetch_User_Data_History($usersession,$reciver,$connect);
}
      // while ($row =mysqli_fetch_assoc($getMessageHistoryFromDB)) 
      // {
      //   $this_user_name = '';
      //   if($row["sender"] == $usersession)
      //   {
      //     $this_user_name = '<b class="text-success">You</b>';
      //   }
      //   else
      //   {
      //      # code...yazid please don forget this part its about the entring message 
      //     echo "hehe";
      //     $this_user_name = '<b class="text-danger">other</b>';
      //   }
      //   $output .= '
      //   <li style="border-bottom:1px dotted #ccc">
      //   <p>'.$this_user_name.' - '.$row["message"].'
      //   <div align="right">
      //   - <small><em>'.$row['date'].'</em></small>
      //   </div>
      //   </p>
      //   </li>
      //   ';

      // }
      // $output .= '</ul>';
      // echo $output;
        
    
?>