<?php
include ("c.php");
session_start();
$username= $_SESSION["name_login"];
$sqlGetContact= "SELECT * FROM contactlist";
$output =  '
<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  
  <td>Action</td>
 </tr>
';


$getContactList=mysqli_query(connectToUserDate($username),$sqlGetContact);
$result=mysqli_num_rows($getContactList);
if ($result>0) {
    while ($row=mysqli_fetch_assoc($getContactList)) {
        $output .= '
        <tr>
         <td>'.$row['userName'].' </br> '.$row['email'].'</td>
         
         <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['userName'].'">Start Chat</button></td>
        </tr>
        ';
       //add buttton here
    }
}
 echo $output .= '</table>';

?>