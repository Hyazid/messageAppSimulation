<?php
session_start();

include './blockchain/c.php';
//include('blockchain/c.php');
function create_avatar($userNameCaracter){
    $path = "images/". $userNameCaracter . ".png";
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
	    imagecolorallocate($image, $red, $green, $blue);  
	    $textcolor = imagecolorallocate($image, 255,255,255);
       // $font = imageloadfont('PLUMBING-BOLD.otf');
       $font ="C:\Windows\Fonts\arial.ttf";
       $text="this is text";
       imagettftext($image, 100, 0, 65, 150, $textcolor, $font, $userNameCaracter[0]);
       
        imagepng($image, $path);
	    imagedestroy($image);
	    return $path;
}


$connect = mysqli_connect("localhost", "root", "", "blockchain");
$bigData=mysqli_connect("localhost", "root", "");

function createDataBAseForUser($name, $userName){
    $sql = "CREATE DATABASE ".$userName;
    $create=mysqli_query(connectToCreate(),$sql);
    if ($create) {
        return "database created for user";
    }
    else {
        return " there is something wrong with function";
    }



}

function connectToSpecificTDB($userNameDB){
    $connectToDBUser=mysqli_connect("localhost", "root", "",$userNameDB);
    return $connectToDBUser;
}

//generate public key and private
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
$resource = openssl_pkey_new($config);

// Extract private key from the pair
openssl_pkey_export($resource, $private_key);

// Extract public key from the pair
$key_details = openssl_pkey_get_details($resource);
$public_key = $key_details["key"];

$keys = array('private' => $private_key, 'public' => $public_key);

$publicUserKey=$keys['public'];
$privateUserKey= $keys['private'];



if ($connect) {
    echo("connect..");
    if (isset($_POST["name"]) and isset($_POST["user_email"]) and isset($_POST["user_name"]) ) {
        $_SESSION["name"]=$_POST["name"];
        $_SESSION["user_email"]=$_POST["user_email"];
        $_SESSION["user_name"]=$_POST["user_name"];
        $name=$_POST["name"];
        $user_email=$_POST["user_email"];
        $user_name=$_POST["user_name"];
        $namef="first";
        $date= date("Y-m-d H:i:s");
        $imagePath=create_avatar($user_name);


        $query= "SELECT * FROM blocks where name='" . $name . "'and email='" . $user_email . "'";
        $insert="INSERT INTO blocks (date,name,userName,publicKey,email,image)
        VALUES('" . $date. "','" . $name. "','" . $user_name . "','" . $publicUserKey . "','" . $user_email . "','".$imagePath."')";
        $res=mysqli_query($connect,$query);
        $result=mysqli_num_rows($res);
        if ($result>0) {
            while ($row=mysqli_fetch_assoc($res)) {
                echo($row['name']);//display//you lall ready exist
                echo($row['userName']);
                echo($row['hash']);
            }
        }
        else {
            echo("nothing there");
            $insertINTO=mysqli_query($connect,$insert);
            if ($insertINTO) {
                echo("data inserted");
                $s=createDataBAseForUser($name,$user_name);
               
                // $packageresult= userConnectToSpace($name,$private_key);
                // echo $packageresult;
                //create contactlist table
                $createContactList ="
                CREATE TABLE contactlist(
                  id INT(11) AUTO_INCREMENT PRIMARY KEY,
                  name VARCHAR(255) NOT NULL,
                  userName VARCHAR(500) NOT NULL,
                  address VARCHAR(500) NOT NULL,
                  publicKey TEXT NOT NULL,
                  email VARCHAR(500)NOT NULL
                  )
                ";
                //create message depo TABLE
                $messageDepo="
                CREATE TABLE message_depo(
                    id INT(11)  AUTO_INCREMENT PRIMARY KEY,
                    message TEXT NOT NULL,
                    reciver VARCHAR(255) NOT NULL,
                    date datetime not null,
                    sender VARCHAR(255) NOT NULL
                    
                )";
                //create message depo crypted
                $messageDepoencrypted="
                CREATE TABLE messagedepo(
                    id INT(11)  AUTO_INCREMENT PRIMARY KEY,
                    message TEXT NOT NULL,
                    reciver VARCHAR(255) NOT NULL,
                    date datetime not null,
                    sender VARCHAR(255) NOT NULL
                    
                )";
                //create private key TABLE
                $privateTable="
                CREATE TABLE privatekey(
                    idKey INT(11)  AUTO_INCREMENT PRIMARY KEY,
                    privateKey TEXT NOT NULL
        
                )";
                //create mutual table key
                $mutual_key="
                CREATE TABLE mutual_key(
                    id INT(11)  AUTO_INCREMENT PRIMARY KEY,
                    Mkey VARCHAR(5000) NOT NULL,
                    userfirst VARCHAR(500) NOT NULL,
                    usersecond VARCHAR(500) NOT NULL
                )";
                //execute queries to create table
                $resultContactlist=mysqli_query(connectToSpecificTDB($user_name),$createContactList);
                $resultMessagedepo=mysqli_query(connectToSpecificTDB($user_name),$messageDepo);
                $resultmutualkey=mysqli_query(connectToSpecificTDB($user_name),$mutual_key);
                $resultprivateTable=mysqli_query(connectToSpecificTDB($user_name),$privateTable);
                $resultMessagedepoEncrypte=mysqli_query(connectToSpecificTDB($user_name),$messageDepoencrypted);
                //insert private key
                $sqlInsertPrivateKey="INSERT INTO ".$user_name.".privatekey (privateKey) VALUES ('".$privateUserKey."') ";
                $exxInsertPrivateKey=mysqli_query($bigData,$sqlInsertPrivateKey);



                
            }
            else {
                echo("il ya une erreur");
            }
            //indert into database
            //create database with his name and userr
            //create table
        }
    }
}
else {
    echo("lost connection");
}




?>


<!-- login part--------------------------------------------------------------->

<?php
    if ($connect) {
        echo ' connect for login';
        if (isset($_POST["login"])) {
            echo 'login button pushed';
            if (isset($_POST["name_login"]) and isset($_POST["user_name_login"]) and isset($_POST['user_email_login'])) {
                echo 'everything set';
               
                $name_login=$_POST["name_login"];
                $user_name_login=$_POST["user_name_login"];
                $user_email_login=$_POST['user_email_login'];
                //check if there is info indatabase
                //if yes redirect to profile.php
                //else
                //$sqlCheck="SELECT * FROM blocks WHERE name='" . $name_login . "'and'" . $user_name_login . "'and'" . $user_email_login . "'";
                $sqlCheck="SELECT * FROM blocks WHERE name='" . $name_login . "'and userName='" . $user_name_login . "' and email ='" . $user_email_login . "'";
                $resultCheck=mysqli_query($connect,$sqlCheck);
                //$rowResultCheck=mysqli_num_rows($resultCheck);
                if ($resultCheck) {
                   
                    if (mysqli_num_rows($resultCheck)>0) {
                        echo '<h4>i gotSOMETHONG </h4>';
                        while ($row=mysqli_fetch_assoc($resultCheck)) {
                            echo("<h4>i got  ".$row['name']."</h4>");//display
                            echo("<h4>i got  ".$row['userName']."</h4>");
                            $_SESSION["name_login"]=$row['name'];
                            $_SESSION["user_name_login"]=$row['userName'];
                            $_SESSION["user_email_login"]=$row['email'];
                            header('location:blockchain/profile.php');
                            
                        }
                        //fetch data
                        //assign to session variable
                        //redirect to profile.php


                    }
                    
                    else {
                        echo '<h4>i gotnothing row =0</h4>';
                    }
                }
                else {
                    echo '<h4>i gotnothing</h4>';
                }


            }
        }

    }

?>





<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css">

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
   
    <title>Document</title>
</head>
<body>
 <div class="container">
        <!---this part in forromulair-->

        
        <div class="row align-items-start">
    
         <div class="col col-md-5,50 mt-6" style="position: absolute;
                left: 0%;
                
                top: 0%;
                bottom: 0%;
                background: #FFFFFF;">
                
                
                <div class="text-notif">
                <img src="images/logo.png" alt="Logo" id="logo">

                    <p class="write1"> Create Your Free Account</p>
                     <p class="write2">Already have an account &nbsp;   <a class="link" href="login.php"> Login </a>  </p>
                </div>

            
                <div class=" form" id="formdiv" style="position: absolute;
                width: 368px;
                height: 337px;
                left: 75px;
                top: 210px;">
                <form method="post" id="register_form" >

                   <div class="form-group " style=" margin-top:30px;">
                        <div class="input-group">
                                <input  type="text" name="name" id="name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required placeholder="Name..."   />
                                <div class="input-group-addon  left-addon">
                                        <i  id="icon1div" class="fas fa-address-card icon"></i> 
                                </div>
                        </div>
                    </div> 

                    <div class="form-group " style=" margin-top:30px;">
                        <div class="input-group">
                            <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required placeholder="User Name..." />
                            <div class="input-group-addon  left-addon">
                                    <i  id="icon1div" class="fa fa-user icon"></i> 
                            </div>
                        </div>
                    </div> 

                    <div class="form-group " style=" margin-top:30px;">
                       <div class="input-group">
                            <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required placeholder="Email..." />
                            <div class="input-group-addon  left-addon">
                                        <i  id="icon1div" class="fa fa-at icon"></i> 
                            </div>
                        </div>
                    </div> 

                    <div class="form-group " style=" margin-top:30px;">
                    <div class="input-group">
                            <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required placeholder="Password..."/>
                            <div class="input-group-addon  left-addon">
                                        <i  id="icon1div" class="fas fa-lock icon "></i> 
                            </div>
                        </div>
                    </div> 

                <div class="form-group text-center" >
                    <input type="submit" name="register" class="btn btn-success" value="Register" id="btn-register" />
                </div>

                 </form>
                </div> 
                
            </div>
        </div>

        <!---this is new container-->
        <div class="col-6,50" style="position: absolute;
            left: 45%;
            right: 0%;
            top: 0%;
            bottom: 0%;
            background: #497173;" >
            <img src="images/background.png" alt="Logo" id="background-image">

        </div>
     <!-- <div class="col col-md-4 mt-5">
      this is a login part
       <div class='card'>
         <div class="card-header">Login</div>
          <div class="formLogin" id="formLogin">
                    <form  method="post" class="login-form" id="login-form">

                    <div class="form-group">
                        <label>Enter Your Name</label>
                        <input type="text" name="name_login" id="name_login" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                    </div>
                    <div class="form-group">
                        <label>Enter Your UserName</label>
                        <input type="text" name="user_name_login" id="user_name_login" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                    </div>
                    <div class="form-group">
                        <label>Enter Your Email</label>
                        <input type="text" name="user_email_login" id="user_email_login" class="form-control" data-parsley-type="email" required />
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" name="login" class="btn btn-success" value="login" />
                    </div>


                    </form>
          </div>

        </div>
     </div>         -->


     
    </div>
    
</body>
</html>
<script>
    $(document).ready(function(){

$('#register_form').parsley();

});
</script>