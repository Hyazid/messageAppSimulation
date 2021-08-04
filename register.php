<?php
session_start();

include './blockchain/c.php';



$connect = mysqli_connect("localhost", "root", "", "blockchain");
//$connectForCreating=mysqli_connect("localhost", "root", "");

function createDataBAseForUser($name, $userName){
    $sql = "CREATE DATABASE ".$name;
    $create=mysqli_query(connectToCreate(),$sql);
    if ($create) {
        return "database created for user";
    }
    else {
        return " there is something wrong with function";
    }



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
        $date=date("l jS \of F Y h:i:s A");


        $query= "SELECT * FROM blocks where name='" . $name . "'and email='" . $user_email . "'";
        $insert="INSERT INTO blocks (date,name,userName,publicKey,email)
        VALUES('" . $date. "','" . $name. "','" . $user_name . "','" . $publicUserKey . "','" . $user_email . "')";
        $res=mysqli_query($connect,$query);
        $result=mysqli_num_rows($res);
        if ($result>0) {
            while ($row=mysqli_fetch_assoc($res)) {
                echo($row['name']);//display
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
               
                $packageresult= userConnectToSpace($name,$private_key);
                echo $packageresult;

                
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

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
   
    <title>Document</title>
</head>
<body>
 <div>
        <!---this part in forromulair-->
        <h1>welcom msg v0.1</h1>
        <h2> check for new Message signin /login</h2>
        <button onclick="register()"> Login</button>


      <div class="col col-md-4 mt-5">
      <?php
             
                ?>
        <div class="card" >
            <div class="card-header">Register</div>
            <div class=" form" id="formdiv">
                <form method="post" id="register_form" >

                
                <div class="form-group">
                    <label>Enter Your Name</label>
                    <input type="text" name="name" id="name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                </div>
                <div class="form-group">
                    <label>Enter Your UserName</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                </div>

                <div class="form-group">
                    <label>Enter Your Email</label>
                    <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required />
                </div>

                <div class="form-group">
                    <label>Enter Your Password</label>
                    <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required />
                </div>

                <div class="form-group text-center">
                    <input type="submit" name="register" class="btn btn-success" value="Register" />
                </div>

             </form>
            </div>


         </div>
     </div>


     <div class="col col-md-4 mt-5">
      <!-- this is a login parte-->
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
     </div>        



    </div>
    
</body>
</html>
<script>
    $(document).ready(function(){

$('#register_form').parsley();

});
</script>