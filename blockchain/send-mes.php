<?php
include ('c.php');
include('encrypteMutual.php');
//const CIPHER_METHOD = 'AES-256-CBC';
session_start();
$connect=mysqli_connect("localhost", "root", "");
//////////////////////////////////////
$usersession= $_SESSION["name_login"];
$reciver =  $_POST['to_user_name'];
$message= $_POST['chat_message'];
//get reciver public key,
$sqlGetPublickKeyFromBlockchain="SELECT * From blockchain.blocks WHERE userName= '".$reciver."'";
$getPublicKeyFromBlockchain=mysqli_query($connect,$sqlGetPublickKeyFromBlockchain);
$rowsPublicKeyFromBlockchain=mysqli_num_rows($getPublicKeyFromBlockchain);
$reciverPublicKey='';
if ($rowsPublicKeyFromBlockchain>0) {
  
  while ($row=mysqli_fetch_assoc($getPublicKeyFromBlockchain)) {
    
    $reciverPublicKey.=$row['publicKey'];
  }

}else{echo("i gotnothing");}
$reciverPublicKey.='';
//echo $reciverPublicKey;
//////////////////////////////////
//////////////////////////////////
//getReciverPrivate key
$sqlGetReciverPrivateKey="SELECT * FROM ".$reciver.".privatekey";
$getReciverPrivateKey=mysqli_query($connect, $sqlGetReciverPrivateKey);
$reciverPrivateKey='';
$rowsGetPrivateKey=mysqli_num_rows($getReciverPrivateKey);
if ($rowsGetPrivateKey>0) {
  while ($rowPrivate=mysqli_fetch_assoc($getReciverPrivateKey)) {
    
    $reciverPrivateKey.= $rowPrivate['privateKey'];
  }
}
$reciverPrivateKey.='';
//echo $reciverPrivateKey;
//////////////////////////////////
/////////////////////////////////
//create file with reciver whre i store the messages send to reciver crypted
//select all messages sent from user session to reciver and put them in file;
$htmllistContainer="<ol>";


$sqlSelectAllMessageOfReciver=$sqlGetMessageHistory = "SELECT * FROM ".$reciver.".message_depo WHERE reciver='".$usersession."' ORDER BY date DESC";
$SelectAllMessageOfReciver=mysqli_query($connect, $sqlSelectAllMessageOfReciver);
$rowSelectMessageOfReciver=mysqli_num_rows($SelectAllMessageOfReciver);
if ($rowSelectMessageOfReciver>0) {
  while ($rowSelect=mysqli_fetch_assoc($SelectAllMessageOfReciver)) {
    $htmllistContainer.="<li>message: ".$rowSelect['message']."  date: ".$rowSelect['date']."</li>";
  }
}
$htmllistContainer.="</ol>";// crypte this variable // clear test
// openssl_public_encrypt($htmllistContainer, $encryptedHTMLContainer,$reciverPublicKey);//user reciver public key
// // Use base64_encode to make contents viewable/sharable
// $messageEncrypted = base64_encode($encryptedHTMLContainer);
$linkToMessageDepo="http://localhost:80/phpmyadmin/db_structure.php?server=1&db=".$usersession."";
echo $reciver;
//try to inser Crypted Message with mutual key
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

///this is for all exchage message json file
$jsonFile="exchange.json";
$current_file=file_get_contents($jsonFile);
// decode json
$arraydata=json_decode($current_file,true);
//add data
$arraydata[]=array(
  "sender" =>$usersession,
  "reciver"=>$reciver,
  "date"=>$insertDate,
  "message"=>$message
);

$final=json_encode($arraydata);
//file_put_contents(''.$usersession.' to'.$reciver.'.json',insertIntoJson($usersession,$reciver,$connect));

/////////////////////////////////////
if ($insertMessageInMessageDepo) {
  echo fetch_User_Data_History($usersession,$reciver,$connect);
  getDataAndHistoryFromBothSide($connect,$usersession,$reciver);
}





//////////////////////////////
//aother cripte withtentative with mutual key i
$fileForReciverToEncrypted=$reciver.".enc.html";
$newfileForReciverClear=$reciver.".dec.html";
$mutualKeyUsersession='';
$mutualKeyReciver='';
$sqlGetMutualKeyReciver="SELECT Mkey FROM ".$reciver.".mutual_key WHERE usersecond='".$usersession."'";
$sqlGetMutualKeyUsersession="SELECT Mkey FROM ".$usersession.".mutual_key WHERE usersecond='".$reciver."'";
$getMutualkeyReciver=mysqli_query($connect, $sqlGetMutualKeyReciver);
$getMutualkeyUsersession=mysqli_query($connect, $sqlGetMutualKeyUsersession);
while ($rowR=mysqli_fetch_assoc($getMutualkeyReciver)and $rowU=mysqli_fetch_assoc($getMutualkeyUsersession)) {
  $mutualKeyReciver.= $rowR['Mkey'];
  $mutualKeyUsersession.= $rowU['Mkey'];
}
$mutualKeyReciver.='';
$mutualKeyUsersession.='';
if ($mutualKeyReciver==$mutualKeyUsersession) {
    $crypteData=FullCryptedFileForReciver($fileForReciverToEncrypted,$mutualKeyUsersession,$htmllistContainer);
    $decrypData=FullDecryptedFileForReciver($fileForReciverToEncrypted, $mutualKeyUsersession);
    saveDecryptedDataInNewReciverFile($newfileForReciverClear,$decrypData);

}

//add pathfile wherereciver can get his path to  the message repository
//insertPathInFileCrypted($reciver,$usersession,$reciver,);
//get mutual key to encrypteMutual
$sqlGetMutualKey="SELECT Mkey FROM ".$usersession.".mutual_key WHERE usersecond='".$reciver."'";
$resultGetMutualKey=mysqli_query($connect, $sqlGetMutualKey);
if ($resultGetMutualKey) {
  while ($rowMutualKey=mysqli_fetch_assoc($resultGetMutualKey)) {
    //echo("the mutual key-->".$rowMutualKey['Mkey']);
    $mutual_key=$rowMutualKey['Mkey'];
    $cryptedLink=insertPathInFileCrypted($reciver,$usersession,$reciver,$mutual_key);
    $decryptedLink=getCryptedLinkFromFile($reciver,$mutual_key);
    echo($decryptedLink);
    
  }

}
else {
  echo("i cant get the mutual key");
}

//insert a crypted message to message depo
//cryted message
$cryptedMessage=encryptWithMutualKey($mutualKeyUsersession,$message);
echo $cryptedMessage;
$allMessageCrytedFromMessageDepo='';
$sqlInsertCryptedMessageToDepo="INSERT INTO ".$usersession.".messagedepo (message,reciver,date) VALUES ('" . $cryptedMessage . "','" . $reciver . "','". $insertDate."')";
$insertCryptedMessgaeInMessageDepo=mysqli_query($connect, $sqlInsertCryptedMessageToDepo);

$sqlGetCrytedMessageFromMessageDepo="SELECT * FROM ".$usersession.".messagedepo";
$getCryptedMessageFromMessageDepo=mysqli_query($connect, $sqlGetCrytedMessageFromMessageDepo);
$numMessageCrypted=mysqli_num_rows($getCryptedMessageFromMessageDepo);
if ($numMessageCrypted>0) {
   while ($rowCrypetdMessage=mysqli_fetch_assoc($getCryptedMessageFromMessageDepo)) {
    $allMessageCrytedFromMessageDepo.=$rowCrypetdMessage['message'];
   }
  echo("i giot something");
}else{echo("nothing");}

//this for demonstration how message depo is cryted with key and decrypted with key
$depoCryptedMessageFile=$usersession."depo.html";
$depoDecryptedMessageFile=$usersession.".depo.dec.html";
 $allMessageCrytedFromMessageDepo.='';
 saveDecryptedDataInNewReciverFile($depoCryptedMessageFile,$allMessageCrytedFromMessageDepo);//save crypted data in file
 $decrypteMessageDepo=FullDecryptedFileForReciver($depoCryptedMessageFile,$mutualKeyUsersession);//get data and decrypt them
 //echo "---->".$decrypteMessageDepo;
 //saveDecryptedDataInNewReciverFile("Decryte DEPO Message".$usersession.".html",$decrypteMessageDepo); 



      
        
    




 function insertIntoJson($sender,$reciver, $connect){
    $query="SELECT test.message_depo.message, james.message_depo.message,test.message_depo.reciver,james.message_depo.reciver
    FROM test.message_depo INNER JOIN james.message_depo
    ON test.message_depo.sender = james.message_depo.reciver WHERE test.message_depo.reciver='james'";
    $sqlGetFromReciver='SELECT * FROM '.$reciver.'.message_depo WHERE reciver="'.$sender.'"ORDER by date DESC';
    $exequery=mysqli_query($connect, $query);
    $exequeryReciver=mysqli_query($connect, $sqlGetFromReciver);
    $exeRow=mysqli_num_rows($exequery);
    if ($exeRow>0) {
      while($row=mysqli_fetch_assoc($exequery)){

        $data[]=array(
          "sender"=>$row['sender'],
          "reciver"=>$row['reciver'],
          "data"=>$row['date'],
          "message"=>$row['message']

        );
      }
    }
     return  json_encode($data);
 }
?>
<!-- SELECT test.message_depo.message, james.message_depo.message
  FROM test.message_depo INNER JOIN james.message_depo
  ON test.message.sender = james.message_depo.reciver; -->
  <!-- SELECT test.message_depo.message, test.message_depo.reciver, test.message_depo.date,james.message_depo.message,james.message_depo.reciver, james.message_depo.date 
  FROM test.message_depo INNER JOIN james.message_depo 
  ON test.message_depo.sender = james.message_depo.reciver 
  WHERE test.message_depo.reciver='james' -->

  <!-- SELECT test.message_depo.message, test.message_depo.reciver, test.message_depo.date,james.message_depo.message,james.message_depo.reciver, james.message_depo.date 
  FROM test.message_depo INNER JOIN james.message_depo ON test.message_depo.sender = james.message_depo.reciver WHERE test.message_depo.reciver='james' 
  GROUP BY test.message_depo.reciver and james.message_depo.sender -->