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
         <button type="button" class="chat btn btn-primary" id="show-chat-btn">show  tour Contact</button>
        </div>
        <div class="showContact"></div>
        <div id="user_model_details"></div>
        <div id="history"></div>



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






</div>
</div>


</div>

</body>


</html>

<script>

    //$.noConflict();
    $(document).ready(function(){

        setInterval(function(){
 
         update_chat_history_data();
        }, 3000);

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

    //////////////////////
    $("#show-chat-btn").click(function(){
        
        $.get("show-contact.php",function(data, status){
            $(".showContact").html(data)
        })
    });

    function make_chat_dialog_box(to_user_id, to_user_name)
    {
        var modal_content = '<div id="user_dialog_'+to_user_name+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
        
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_name+'" id="chat_history_'+to_user_name+'">';
        modal_content += fetch_User_Chat_History(to_user_name);
        modal_content += '</div>';
        
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_'+to_user_name+'" id="chat_message_'+to_user_name+'" class="form-control"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content+= '<button type="button" name="send_chat" id="'+to_user_name+'" class="btn btn-info send_chat">Send</button></div></div>';
        $('#user_model_details').html(modal_content);
    }
    $(document).on('click', '.start_chat', function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        make_chat_dialog_box(to_user_id, to_user_name);
        console.log(""+to_user_id);
        console.log(""+to_user_name);
         $("#user_dialog_"+to_user_name).
          dialog({
               autoOpen:false,
               width:400
         
          });
          $('#user_dialog_'+to_user_name).dialog('open');
    });
    $(document).on('click','.send_chat', function(){
        var to_user_name = $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_name).val();
        console.log("send...");
        $.ajax({
            url:"send-mes.php",
            method:"POST",
            data:{to_user_name:to_user_name, chat_message:chat_message},
            success:function(data){
                
                $('#chat_message_'+to_user_name).val('');
                $('#chat_history_'+to_user_name).html(data);
            }
        })
    })

    ////////////////
     function fetch_User_Chat_History(to_user_name){
         $.ajax({
             url:"fetch_user_chat_history.php",
                method:"POST",
                data:{to_user_name:to_user_name},
                success:function(data){
                    
                    $('#chat_history_'+to_user_name).html(data);
                }
           
        })
     }
     function update_chat_history_data()
    {
        $('.chat_history').each(function(){
        var to_user_name = $(this).data('touserid');
        fetch_user_chat_history(to_user_name);
        });
    }

    
    



 
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