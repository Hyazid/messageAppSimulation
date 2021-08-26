<?php
    include('c.php');
   // mysqli_query($connect,"");
    session_start();
    $nameuser=$_SESSION["name_login"];
    $unserNameLogin=$_SESSION["user_name_login"];
    echo($nameuser);
    echo($unserNameLogin);
    $imageuser='';
    //get User image
    //get username and email from blockchain
    $sqlGetContactFromBlockchain="SELECT * FROM blockchain.blocks WHERE userName='".$unserNameLogin."'";
    $getContactFromBlockchain=mysqli_query($connect, $sqlGetContactFromBlockchain);
    $rowContactFromBlockchain=mysqli_num_rows($getContactFromBlockchain);
    if ($rowContactFromBlockchain>0) {
        while ($rowImage= mysqli_fetch_assoc($getContactFromBlockchain)) {
            $imageuser.=$rowImage['image'];
        }
    }
    $imageuser.='';
    $linkImage='../'.$imageuser;
    //////////////////////////////////////
    if (isset($_GET['searchBtn'])) {
        //$search_query = preg_replace('#[^a-z 0-9?!]#i',"",$_POST["search-bar"]);
        header('loacation: http://loacalhost/message/blockchain/searchAll.php');
        echo "button pushed";

    }


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
      <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="profile.css">
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
    <title>Document</title>
</head>


<body scroll="no" style="
    overflow: hidden;
    background-color: #AFC5E9;
    
    
    ">
    
    <div class="container" style="
        position: relative;
        background-color:#EFF5F5;
        border: 3px solid black ;
        border-radius: 39px;
        width: 1140px;
        height:600px
        ">
        <div class="row align-items-start" id="row">
            <div class="col"id="porfil-avatar">
              <img src=<?php echo $linkImage?> alt="user" style="border-radius: 50%; width: 70px; height: 70px;">
              <p id="avatar-text"> <?php  echo ($nameuser)?></p>  

              <!--notificat-->
              <ul class="nav navbar-nav navbar-right" id="nav">
                    <li> 
                    <!-- env   -->
                    <div class="text-right">
                    <!-- <i class="glyphicon glyphicon-envelope" style="font-size:20px" id='env'></i> -->
                    <div class="showContact-btn"></div>
                    <div class="showDialog-btn"></div>
                    </div>
                    <!-- env   --> 
                    </li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="contact_request">
                        <span id="unseen_contact_request_area"></span>
                        <i class="fa fa-bell fa-2x" aria-hidden="true" id="bell"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" id="contact_request_list" style="width: 300px; max-height: 1000px;">
                    </ul>
                    </li>
                </ul>
            </div>
            <div class="col col-md-5,50 mt-6" id="fcol" style="
                border-radius: 25px 25px 0px 0px;
                position: absolute;
                left: 44.10%;
                border: solid 3px red;
                width: 500px;
                height: 550px;
                top:50px;
                
            
                background-color: #FDFDFD;
            
            " >
               
                <div id="text-div" style=" height: 38px;">
                    <p  id="text-chat"><b> Chat</b></p>
                </div>
                <!--notification-->
                <div class="table-responsive">
                   
                    <div id="user_model_details"></div>
                    <div id="history"></div>
                    <!-- create a message simple box chat-->
                </div>
            </div>
            <!--this is for chowing all contact with start button chat-->
            <div class="col-2,50" id="scol" style="
                 
                    border: solid 3px green;
                    position: absolute;
                    left: 14.2%;
                    width: 330px; 
                    height: 100%px;
                    top: 0.05%;
                    bottom: 0%;
                    background: #EFF5F5;
                    " >
                    <!-- serach bar   -->
                    <form action="searchAll.php" class="navbar-form navbar-left" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-bar" name="search-bar" placeholder="search..." autocomplete="off"/>
                                
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default" name="searchBtn" id="searchBtn">
                                    <i class="glyphicon glyphicon-search" aria-hidden="true" id="loop"></i>
                                    </button>
                                </div>
                                
                            </div>
                            <div class="countryList" id="countryList" style="position:absolute; width: 500px;z-index: 1001;">
                            </div>      
                        </form>
                
                <!-- search bar   -->
            <div class="showContact" id="showContact" style="
                    position: absolute;
                    top: 120px;
                    height: 470px;
                    left:5px;
                    border: solid 3px blue;
            "
            ></div>
            </div>
            <!--this for th bar on the letf log out-->
            <div class="col" id="col-logout" style="
                background-color: #497173;
                position: absolute;
                border-radius: 26px;
                width:80px;
                height: 560px;
                left: 30px;
                top :20px;
               
                ">
                <div class="logo" id=" logo" style="
                position: absolute;
                width: 60px;
                height: 60px;
                left: 10px;
                top:10px;
                " >
                <img src="../images/logoM.png" alt="logo" style="width: 100%; height: 100%;" >
                </div>
                <div class="logout" style="
                    position: absolute;
                    top: 88%;
                    
                    
        
                    ">
                    
                    <a href="logout.php" id="logout-link" > <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
                    <br><p class="logout-text">Logout</p>
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
         count_Unseen_Contact_Request();
        }, 1000);

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
   // $("#show-chat-btn").click(function(){
        //show the contact list
        $.get("show-contact.php",function(data, status){
            $(".showContact").html(data)
        })
    //});

    function make_chat_dialog_box(to_user_id, to_user_name)
    {
        var modal_content = '<div id="user_dialog_'+to_user_name+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
        
        modal_content += '<div style="height:380px; border:2px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_name+'" id="chat_history_'+to_user_name+'">';
        modal_content += fetch_User_Chat_History(to_user_name);
        modal_content += '</div>';
        
        modal_content += '<div class="form-group" id="msg-input">';
        modal_content += '<textarea name="chat_message_'+to_user_name+'" id="chat_message_'+to_user_name+'" class=""></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content+= '<button type="button" name="send_chat" id="'+to_user_name+'" class="send_chat"><p id="send">Send <i class="fa fa-paper-plane" id="plane" aria-hidden="true"></i></p></button></div></div>';
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

    //when the button is pushed redirect to another page
    //and pass the user name data
//    function goToAllImage(to_user_name){
//        alert(to_user_name);
//        $.ajax({
//            url:'showMessageReciver.php',
//            method:'POST',
//            data:{to_user_name:to_user_name},
//            success:function(){
//                window.location='showMessageReciver.php';
//            }
//        })
//    }
    
    $("#env").click(function(){
        $.get("getContact.php",function(data,status){
            alert(data);
            $(".showContact-btn").html(data);
        }) 
    });
    $(document).on('click','.show_chat', function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        //showMessagesInDialogWindow(to_user_name)
        $.ajax({
            url:'showMessagePerUser.php',
            method:'POST',
            data:{to_user_name:to_user_name},
            success:function(data){
                    //$("#show-all-msg"+to_user_name).html(data);
                    alert(data)
                    //$("#show-all-msg"+to_user_name).html(data);
                    //showMessagesInDialogWindow(to_user_name);
                    $("#history").html(data);
                    
                    

            }

        })
        
    });
    $("#search-bar").keyup(function(){

        var query = $(this).val();
        if(query !=''){
            $.ajax({
                url:'getContactFromBlockchain.php',
                method:'Post',
                data:{query:query},
                success:function(data){
                    $("#countryList").html(data);
                }
            })
        }else{
            $("#countryList").html('');
        }

    });
    $(document).on('click','.list-group-item', function(){
        alert("workin");
        $("#search-bar").val($.trim($(this).val()));
        $("#countryList").fadeOut();
    })
    //this action is for notification 
    function count_Unseen_Contact_Request(){
        var action = 'unseen_countact_request';
        $.ajax({
            url:'contact_action.php',
            method:'POST',
            data:{action:action},
            success:function(data){
                if (data>0) {
                    $('#unseen_contact_request_area').html(
                        '<span class="label label-danger">'+data+'</span>'
                    )
                }
            }
        })
    }
    function load_Contact_request_list(){
        var action ="load_contact_request";
        $.ajax({
            url:'contact_action.php',
            method:'POST',
            data:{action:action},
            beforeSend:function(){
                $('#contact_request_list').html(
                    '<li align="center"> <i class="fas fa-circle-notch  fa-spin  " style="font-size: 24px;"></i></li>'
                );
            },
            success:function(data){
                alert(data);
                $('#contact_request_list').html(data);
                removeNotificationNumber();
                
            }
        })

    }
    //load_Contact_request_list();
    $('#contact_request').click(function(){
        load_Contact_request_list();
        
    });
    function removeNotificationNumber(){
        
        $.ajax({
            url:'contact_action.php',
            method:'POST',
            data:{action:'remove_notification'},
            success:function(data){
                $('#unseen_contact_request_area').html('')
            }
        });
    }
    $('.dropdown-menu').click(function(event){
        event.preventDefault();
        var request = event.target.getAttribute('data-request_userName');
        alert(request);
        if (request!='') {
            $.ajax({
                url:'contact_action.php',
                method:'POST',
                data:{request:request,action:'confirm'},
                beforeSend:function(){
                    $('#accept_request_'+request+'').attr('disabled','disabled');
                    $('#accept_request_'+request+'').html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> wait...');

                },
                success:function(data){
                    alert(data);
                    load_Contact_request_list();
                }
            })
        }
        return false;
    })
    $('td').hover(function(){
        alert("this working");
    });

    
    

    


   
    
    











    function showMessagesInDialogWindow(to_user_name){
      var modal=  '<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">';
        modal+= '<div class="modal-dialog" role="document">';
        modal+='<div class="modal-content">';
        modal+='<div class="modal-header">';
        modal+='<h5 class="modal-title" id="exampleModalLongTitle">From '+to_user_name+'</h5>';
        modal+='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modal+='<span aria-hidden="true">&times;</span>';
        modal+='</button></div>';
      
        modal+='<div class="modal-body" id="show-all-msg'+to_user_name+'">heeeeput info';
        
        modal+='</div>';
        modal+= '<div class="modal-footer">';
        modal+='<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        
      modal+='</div></div></div></div>';
      $(".showDialog-btn").html(modal);

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