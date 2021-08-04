<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
//get data from index .html table
session_start();

$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password,"blockchain");
if ($conn) {
    if(isset($_POST["name"])and isset($_POST["user_name"]) and isset($_POST["user_email"])and isset($_POST["user_password"]) ){

        $name=$_POST["name"];
        $userName=$_POST["user_name"];
        $email=$_POST["user_email"];
        $pass=$_POST["user_password"];
        $sql="SELECT * FROM blocks";//
        $sql1 = "SELECT  'name', 'userName' FROM blocks WHERE name='first'";

        $result = $conn->query($sql1);;
        if ($result) {
            echo "New record created successfully";
          }
    }
}
   
 






?>


<div> <h4><button>generate</button></h4></div>


</body>
</html>