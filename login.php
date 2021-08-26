<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "blockchain");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Part</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="login.css">
        <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

        <!-- Bootstrap core JavaScript -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="vendor-front/jquery/jquery.min.js"></script>
        <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>
        
        <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
</head>
<body>
    
    <div class="container">
        <div class="row align-items-start">
            <div class="col col-md-5,50 mt-6" id="form-container">   
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
                    <p class="card-text">Don't have an account ? <a href="register.php">Sign up</a></p>
                </div>
            </div> 
        
            <div class="col-7" id="pic-container">
                <img src="images/main3.jpg" alt="main" >
            </div>
        </div>
        
    </div>
    

</body>
</html>