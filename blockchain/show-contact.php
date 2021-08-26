<?php
include ("c.php");
session_start();
$username= $_SESSION["name_login"];
$sqlGetContact= "SELECT * FROM contactlist";

$output =  '</br>
<table class="table " id="show-contact-table">
 <tr>
  <td style="
  font-style: normal;
    
    font-weight: bold;
    font-size: 30px;
    line-height: 37px;

    color: #42474F;
  ">Contacts</td>
  
  <td></td>
 </tr>
';


$getContactList=mysqli_query(connectToUserDate($username),$sqlGetContact);
$result=mysqli_num_rows($getContactList);
if ($result>0) {
    while ($row=mysqli_fetch_assoc($getContactList)) {

        $output .= '
        <tr style="border:none;">
          <td><button type="button" class="start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['userName'].'">'.GetImageFromBlockchain($row['userName'], $connect).'<p id="contact-UN">'.$row['userName'].'</p></button> </td>
         </tr>
         
      
        ';
       //add buttton here
    }
}
 echo $output .= '</table>';

 function GetImageFromBlockchain($userImage, $connect){
    $sqlGetImageFromBlckchain="SELECT * FROM blockchain.blocks where userName='".$userImage."'";
    $exeGetImageFromBlockchain=mysqli_query($connect, $sqlGetImageFromBlckchain);
    $imageUserName='';
    $checkresult=mysqli_num_rows($exeGetImageFromBlockchain);
    if ($checkresult>0) {
        while ($row=mysqli_fetch_assoc($exeGetImageFromBlockchain)) {
            $imageUserName.=$row['userName'];
        }
        return '<img src="../images/'.$imageUserName.'.png"  alt="user" id="contact-list-image">';
    }
 }
?>