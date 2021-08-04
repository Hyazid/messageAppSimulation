<?php
    include('c.php');
   // mysqli_query($connect,"");
    session_start();
    $nameuser=$_SESSION["name_login"];
    $unserNameLogin=$_SESSION["user_name_login"];
    echo($nameuser);
    echo($unserNameLogin);
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Bootstrap core CSS -->
        <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <div class="container">

    <h3 align="center"> welcom</h3>
    <div class="table-responsive">
        <p align="center">hi <?php  echo ($nameuser);?> </p>
        <p align="right"><a href="logout.php" > Logout</a></p>
        <br/>
        <br/>
        <div class="btn">
         <button type="button" class="showbtn btn btn-success" id="btn-chat">discussion with test</button>
        </div>
        <!-- create a message simple box chat-->
<div>


<div id="showhideForm" >
  <div class="form-group">

    <label for="exampleFormControlTextarea1">test echange with test01</label>
    <div class="form-group">
        <input type="text" class="form-control" id="reciver" name="reciver"  placeholder="reciver.id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="objectMesage" name="object-message"  placeholder="object">
    </div>

   
    <div class="form-group">
        <textarea class="form-control" id="message" rows="10" placeholder="write message" ></textarea>
    </div>


    <div class="text-right">
        <button type="button" class="hidebtn btn btn-warning" id="btn-chat" >close</button>
    </div>

    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
  </div>


</div>

<div class="chatbtn text-right">
<button type="button" class=" btn btn btn-primary chat_btn" id="btn-chat-try" data-tousername="test" >send message to test</button>
</div>
<div id="#user_model_details"></div>



</div>
</div>


</div>

</body>


</html>

<script>
    $(document).ready(function(){

	$('.hidebtn').click(function(){
  		$('#showhideForm').hide(500);
  	});
    $('.showbtn').click(function(){
    
  		$('#showhideForm').show(500);
  	});
    $("#submit").click(function(){
        var reciver = $("#reciver").val();
        var object = $("#objectMesage").val();
        var message=$("#objectMesage").val();
        $.post("send.php",
        {
            reciver: reciver,
            object:object,
            message:message
            
        },
        function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
        });
    })
    



 
});
</script>
<style>
#showhideForm{
   
	display: none;
    width: 400px;
    border: 1px solid #ccc;
    padding: 14px;
    background: #ececec;
}	
</style>