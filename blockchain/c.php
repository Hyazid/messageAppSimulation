<?php

function connectToCreate(){
     $connectForCreating=mysqli_connect("localhost", "root", "");
     return $connectForCreating;
}
$connect=mysqli_connect("localhost", "root", "");

function connectToUserDate($usernameDatabase)
{
    $connect=mysqli_connect("localhost", "root", "",$usernameDatabase);
    
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
            privateKey VARCHAR(500) NOT NULL

        )";

        $mutual_key="
        CREATE TABLE mutual_key(
            id INT(11)  AUTO_INCREMENT PRIMARY KEY,
            key VARCHAR(500) NOT NULL,
            user1 VARCHAR(500) NOT NULL,
            user2 VARCHAR(500) NOT NULL

        )";
        $personelKey="
        CREATE TABLE personelkey(
            id INT(11)  AUTO_INCREMENT PRIMARY KEY,
            key VARCHAR(500) NOT NULL
            
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