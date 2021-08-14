<?php
include ("c.php");
session_start();
$username= $_SESSION["name_login"];
$sqlGetContact= "SELECT * FROM contactlist";
$output =  '';


 $getContactList=mysqli_query(connectToUserDate($username),$sqlGetContact);
 $result=mysqli_num_rows($getContactList);
 if ($result>0) {
     while ($row=mysqli_fetch_assoc($getContactList)) {
         $output .= '
        
        <button type="button" class="btn btn-light show_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['userName'].'">'.$row['userName'].'</button>
        ';
        
       
     }
 }
  echo $output .= '';

?>