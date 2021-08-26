<?php
include('c.php');
session_start();
$userNameSession=$_SESSION['name_login'];
$userName= $_POST['userName'];
$email = $_POST['email'];
//generate mutual key
$permitted_chars = 'ABCDEFGHIJK';
function generate_string($input, $strength = 5) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}

$string_length = 4;
$mutualKey = generate_string($permitted_chars, $string_length);



//get data from blockchain
$sqlGetDataFromBlockchain="SELECT * FROM blockchain.blocks WHERE userName='".$userName."'";

$output='';
$nameBlockchain='';//get name from blockcahin
$usernameBlockchain='';// getusername from blockchain;
$publickKeyBlockchain='';//get publickey from blockchain
$email_blockchain=''; //get email from blockchain
//request insert mutual key in username mutual key table
$sqlInsertMutualKey='INSERT INTO '.$userNameSession.'.mutual_key (`Mkey`,`userfirst`,`usersecond`) VALUES ("'.$mutualKey.'","'.$userNameSession.'","'.$userName.'")';
//check user in contact list 
$sqlcheckIfInContacList="SELECT * FROM ".$userNameSession.".contactlist WHERE userName='".$userName."'";

$checkIfInContactList =mysqli_query($connect, $sqlcheckIfInContacList);
//get data from GetDataFromBlockchain
$gteDataFromBlockchain=mysqli_query($connect,$sqlGetDataFromBlockchain);

$rowCheck=mysqli_num_rows($checkIfInContactList);
if ($rowCheck>0) {
    $output.= '<i class="fa fa-user-plus" >'.$userName.'  '.$userNameSession.'</i>';

}

else 
{
    //fetch data from blockchain 
    while ($rowBlock= mysqli_fetch_assoc($gteDataFromBlockchain)) {
        $nameBlockchain.=$rowBlock['name'];
        $usernameBlockchain.=$rowBlock['userName'];
        $email_blockchain.=$rowBlock['email'];
        //echo "--->".$rowBlock['publicKey'];
        $publickKeyBlockchain.=$rowBlock['publicKey'];//concatination new values 
    }

    $usernameBlockchain.='';
    $nameBlockchain.='';
    $email_blockchain.='';
    $publickKeyBlockchain.='';
    //request to insert in contact list
    $sqlInsertInContactList='INSERT INTO '.$userNameSession.'.contactlist (`name`,`userName`,`publicKey`,`email`) VALUES ("'.$nameBlockchain.'","'.$usernameBlockchain.'","'.$publickKeyBlockchain.'","'.$email_blockchain.'")';
    //connect to contact contact db
    $connectToContact= mysqli_connect("localhost","root","","contact");
    //request  to insert in contact db
    $sqlInsertInContact='INSERT INTO `contact`( `from_userName`, `to_userName`, `status_contact`,`notif`) VALUES ("'.$userNameSession.'","'.$userName.'","panding","no")';
    //execute insert request in contact db
    $exeInsertContact=mysqli_query($connectToContact, $sqlInsertInContact);
    //execute insert request to insert in contact list in usersession 
    $exeInsertInContactList =mysqli_query($connect, $sqlInsertInContactList);
    //execute insert in mutual key TABLE
    $exeInsertInMutualKey=mysqli_query($connect, $sqlInsertMutualKey);

    if ($exeInsertContact) {
    
        ///create a special table for the contact 
        $sqlCreateTableForContact="CREATE TABLE ".$userNameSession.".".$userName."(
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        date datetime,
        object varchar(255),
        reciver varchar(255),
        sender varchar(255))";
        $createTableForContact=mysqli_query($connect, $sqlCreateTableForContact);
        if ($createTableForContact) {
            echo " table created ";
        }
        else {
            echo " table non created ";
        }
        ///insert in contactlist in usersession database
        if ($exeInsertInContactList) {
            echo " data inserted in contact list "; 
            echo $publickKeyBlockchain;
        }
        else{echo" data not insert ";}

    }
    else{echo "no----->";}
    
}
$output.=$publickKeyBlockchain;

echo $output





?>