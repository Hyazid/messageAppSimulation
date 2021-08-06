<?php

function connectToCreate(){
     $connectForCreating=mysqli_connect("localhost", "root", "");
     return $connectForCreating;
}
$connect=mysqli_connect("localhost", "root", "");

function connectToUserDate($usernameDatabase)
{
    $connectToDBUser=mysqli_connect("localhost", "root", "",$usernameDatabase);
    return $connectToDBUser;

}
//sender====>usersession
//fetch userdata to get response from the other side
function fetch_User_Data_History($userSession, $reciver, $connect){
    $output = '<ul class="list-unstyled">';
    $sqlGetMessageHistory = 
    "SELECT * FROM ".$userSession.".message_depo WHERE 
    reciver='" . $reciver . "' ORDER BY date DESC";
    $getMessageHistoryFromDB=
    mysqli_query($connect,$sqlGetMessageHistory);
    $resultGetMessageFromDB=mysqli_num_rows($getMessageHistoryFromDB);
    if ($resultGetMessageFromDB>0) {
        while ($row=mysqli_fetch_assoc($getMessageHistoryFromDB)) 
        {
            $this_user_name = '';
            if($row["sender"] == $userSession){
               
               $this_user_name = '<b class="text-success">You</b>';
               echo($row['reciver']);

            }
            else {
                # code...yazid please don forget this part its about the entring message 
                
                $this_user_name = '<b class="text-danger">'.getOtherSideUserName($row['reciver'],$connect).'</b>';
                
            }
            $output .= '
                <li style="border-bottom:1px dotted #ccc">
                <p>'.$this_user_name.' -----> '.$row['reciver'].'---->'.$row["message"].'
                <div align="right">
                   - <small><em>'.$row['date'].'</em></small>
                   </div>
                </p>
                </li>
                ';
          }

          $output .= '</ul>';
        return $output;

    }
    

}


//get other user to display then  in other color from 
//
function getOtherSideUserName($UserName,$connect){
    $query = "SELECT userName FROM blockchain.blocks WHERE userName='". $UserName ."'";
    $queryGetOtherSideUserName=mysqli_query($connect,$query);
    $rowResult=mysqli_num_rows($queryGetOtherSideUserName);
    if ($rowResult>0) {
        echo("igot other username");
        while ($row=mysqli_fetch_assoc($queryGetOtherSideUserName)) {
            return $row['userName'];
        }
    }
}


function userConnectToSpace($name,$privateKey){
    //create connection ro userdatabase
    // create tabble mesage-depo, privatekeytab,contact list, mutual key
    // personnel mutual key
    $connectToSpace=mysqli_connect("localhost", "root", "",$name);
    if ($connectToSpace) {
        $createContactList ="
        CREATE TABLE contactlist(
          id INT(11) AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          userName VARCHAR(500) NOT NULL,
          email VARCHAR(500)NOT NULL
         
        )
        ";

        $messageDepo="
        CREATE TABLE message_depo(
            id INT(11)  AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(500) NOT NULL,
            reciver VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL
            
        )";
        $privateTable="
        CREATE TABLE privatekey(
            idKey INT(11)  AUTO_INCREMENT PRIMARY KEY,
            privateKey VARCHAR(5000) NOT NULL

        )";

        $mutual_key="
        CREATE TABLE mutual_key(
            id INT(11)  AUTO_INCREMENT PRIMARY KEY,
            key VARCHAR(5000) NOT NULL,
            user1 VARCHAR(500) NOT NULL,
            user2 VARCHAR(500) NOT NULL

        )";
        $personelKey="
        CREATE TABLE personelkey(
            id INT(11)  AUTO_INCREMENT PRIMARY KEY,
            key VARCHAR(5000) NOT NULL
            
        )";
        //$insertPrivateKey="INSERT INTO privatekey(privateKey)VALUES('" . $privateKey. "')";
        

        //createtion
        //$resultContactlist=mysqli_query($connectToSpace,$createContactList);
        $resultMessagedepo=mysqli_query($connectToSpace,$messageDepo);
        $resultmutualkey=mysqli_query($connectToSpace,$mutual_key);
        $resultprivateTable=mysqli_query($connectToSpace,$privateTable);
        $resultpersonalkey=mysqli_query($connectToSpace,$personelKey);
        //$resultInsertPrivateKey=mysqli_query($connectToSpace,$createContactList);;
        //for contactlist
        // if ($resultContactlist) {
        //     return "contact liste created perfectly";
        // } else {
        //     return "contact list not created";
        // }
        //for message depoo
        if ($resultMessagedepo) {
            return "message depo created perfectly";
        } else {
            return "message depo not created";
        }
        //for mutualkey table
        if ($resultmutualkey) {
            return "mutualkey created perfectly";
        } else {
            return "mutual key not created";
        }
        //for privatetable
        if ($resultprivateTable) {
            return "privatetable created perfectly";
        } else {
            return "private table not created";
        }
        //for personelKey
        if ($resultpersonalkey) {
            return "personnel created perfectly";
        } else {
            return "personnel table not created";
        }
        




    } 

}
?>