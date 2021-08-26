<?php
 include('c.php');

 session_start();
 $userNameSession=$_SESSION['name_login'];//the main user 
 if (isset($_POST['action'])) {
     if ($_POST['action']=='unseen_countact_request') 
     {
         //get count of notification sent to this user 
         $sqlgetCountNotificationContact="SELECT COUNT(id) as total FROM contact.contact WHERE to_userName='".$userNameSession."' AND status_contact='panding' and notif='no'";
         $exeGetCountNotificationContact=mysqli_query($connect, $sqlgetCountNotificationContact);
         $rowCount= mysqli_num_rows($exeGetCountNotificationContact);
         if ($rowCount>0) {
             while ($row=mysqli_fetch_assoc($exeGetCountNotificationContact)) {
                 echo $row['total'];
             }
         }
         else {
             echo 0;
         }
     }
     if ($_POST['action']=="load_contact_request")
      {
        //get usern Name that send invitation to the USERSESSION
        $sqlGetContactRequestFromContact="SELECT * FROM contact.contact WHERE to_userName='".$userNameSession."' AND status_contact='panding'  ORDER BY id DESC";
        $exeGetContactRequestFromContact=mysqli_query($connect,$sqlGetContactRequestFromContact);
        $rowRequest=mysqli_num_rows($exeGetContactRequestFromContact);
        $output='';
        if ($rowRequest>0) {
            while ($rowContact=mysqli_fetch_assoc($exeGetContactRequestFromContact)) {
                $userNameData=getUserNameFromBlockchain($connect,$rowContact['from_userName']);
                $user_name_email='';
                $user_name='';
                while ($ROW=mysqli_fetch_assoc($userNameData)) {
                    $user_name_email.=$ROW['email'];
                    $user_name=$ROW['userName'];
                }
                $output.='
                <li class="dropdown-item">
                    <b class="text-primary">'.$user_name_email.'</b>
                    </br>
                    <b class="text-primary">'.$user_name.'</b>
                    <button name="accept_contact_request"
                    class="btn btn-primary btn-xs pull-right accept_contact_request"
                    data-request_userName="'.$user_name.'"
                    id="accept_request_'.$user_name.'"
                    >
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Accept
                    </button>
                </li>
                ';
            }
            echo $output;
            
        }
       
     }


     //new 
     if ($_POST['action']=='remove_notification') {
            $sqlChangeForNotification="UPDATE contact.contact SET notif='yes' WHERE to_userName='".$userNameSession."' AND notif='no'";
            $exeChangeForNotification=mysqli_query($connect, $sqlChangeForNotification);
            

     }
     if ($_POST['action']=='confirm') {
         
         $pushedButtonUserNameContact=$_POST['request']; //the username when button add pushed
         echo "working--->  ".$_POST['request']."<----";
         $query="UPDATE contact.contact SET status_contact='confirm' WHERE from_userName='".$_POST['request']."'";
         $exequery=mysqli_query($connect, $query);
         //if contact request is confirmed
         //add in contact list
         //add a new table in user
         //get DATA ABOUT CONTACT From BLOCKCHAIN
         $getInfoContactFromBlockchain=getUserNameFromBlockchain($connect, $_POST['request']);
         $newContactUserName='';
         $newContactName='';
         $newContactPublickey='';
         $newContactEmail='';
         while ($getRow = mysqli_fetch_assoc($getInfoContactFromBlockchain)) {
            //insert new Dtata in contactList 
            $newContactUserName=$getRow['userName'];
            $newContactName=$getRow['name'];
            $newContactPublickey=$getRow['publicKey'];
            $newContactEmail=$getRow['email'];
            $sql="INSERT INTO ".$userNameSession.".contactlist (`name`,`userName`,`publicKey`,`email`) VALUES ('".$newContactName."','".$newContactUserName."','".$newContactPublickey."','".$newContactEmail."')";
            $exeSql=mysqli_query($connect, $sql);

             
         }
         //create table with cntact name
         $sqlCreateTableforNewContact="CREATE TABLE ".$userNameSession.".".$_POST['request']."(
             id INT(11) AUTO_INCREMENT PRIMARY KEY,
             date datetime not null,
             object VARCHAR(255) NOT NULL,
             reciver VARCHAR(255) NOT NULL,
             sender VARCHAR(255) NOT NULL
         )";
         //execute the upper request
         $exeCreateTableForNewContact=mysqli_query($connect, $sqlCreateTableforNewContact);
         


     }
 }
function getUserNameFromBlockchain($connect, $userNameSearch){
    $query ="SELECT * FROM blockchain.blocks WHERE userName='".$userNameSearch."'";
    return $result=mysqli_query($connect, $query);
}
?>