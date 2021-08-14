<?php
const CIPHER_METHOD = 'AES-256-CBC';


function encryptWithMutualKey($key, $plainText){
   
    $key = str_pad($key, 32, '*');
    $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($plainText, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);

    // Return $iv at front of string, need it for decoding
    $message = $iv . $encrypted;
    return base64_encode($message);
}
$enc=encryptWithMutualKey('yazid',"salut je suis yazid je finire le memoire");

function decryptWithMutualKey($key, $messageCipher){
    $key = str_pad($key, 32, '*');
    $iv_with_ciphertext = base64_decode($messageCipher);
    // Separate initialization vector and encrypted string
    $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
    $iv = substr($iv_with_ciphertext, 0, $iv_length);
    $ciphertext = substr($iv_with_ciphertext, $iv_length);

    // Decrypt
    $plaintext = openssl_decrypt($ciphertext, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);
    return $plaintext;
}

//generate rondom key size 4

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
$captcha_string = generate_string($permitted_chars, $string_length);

function insertPathInFileCrypted(  $reciverPath, $sender,$reciver,$MutualKey){
    //path message will be encrypted by the function encrypte
    $file=fopen($reciverPath.".html",'w');
 
    $message='<a href="http://localhost/message/blockchain/'.$reciver.'.dec.html"</a>
    <p>From :'.$sender.'  To:'.$reciver.'</p></br>';
    $linkCrypted=encryptWithMutualKey($MutualKey,$message);
    fwrite($file,$linkCrypted);
    fclose($file);
    return $linkCrypted;
}
// $cipherLink=insertPathInFileCrypted("test","sender","testreciver","123");
// echo $cipherLink;

function getCryptedLinkFromFile($filePath,$key){
    $myfile = fopen($filePath.'.html', "r") or die("Unable to open file!");
    $getLink=fgets($myfile);
    $linkDecrypte=decryptWithMutualKey($key,$getLink);
    return $linkDecrypte;
}

// $linkDecrypted=getCryptedLinkFromFile('test','123');
// echo($linkDecrypted);

function FullCryptedFileForReciver($reciver, $mutualKey,$ClearInsiderFile){
    $file=fopen($reciver,'w');
    $dataCrypted=encryptWithMutualKey($mutualKey,$ClearInsiderFile);
    fwrite($file,$dataCrypted);
    fclose($file);
    return $dataCrypted;

    /**
     * openfile
     * pass parametre message to encrypte
     * pass mutual key
     * encrypte
     * put crypted data in the file
     * return data crypted
     * close file 
     */

}
function FullDecryptedFileForReciver($filepath,$mutualkey){
    $file=fopen($filepath,'r')or die("Unable to open file!");;
    $getData=fgets($file);
    $decryptedData=decryptWithMutualKey($mutualkey,$getData);
    fclose($file);
    return $decryptedData;
    /**
     * open reciver file
     * read data
     * decrypte data with mutual mutualKey
     * return clear data
     */

}
function saveDecryptedDataInNewReciverFile($newFile, $decryptedData){
    
    $file=fopen($newFile,"w");
    fwrite($file,$decryptedData);
    fclose($file);
    /**
     * open new file 
     * put the clear data in it;
     */
}




?>