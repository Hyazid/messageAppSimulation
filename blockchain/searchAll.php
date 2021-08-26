<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    //this code is for showing friend and buttons to add request
    session_start();
    
    include('c.php');
    $userName=$_SESSION['name_login'];
    $searchGET = $_GET['search-bar'];
    $search_bar_query  =preg_replace('#[^a-z 0-9?!]#i',"",$searchGET);
    $output='';
    $condition= "";
    $button='';
    $search_array = explode(" ",$search_bar_query);
    foreach ($search_array as $search) {
        if (trim($search)!='') {
            $condition.="userName LIKE '%".$search."%' OR"; 
            
        }
    }
    $condition.="";
    echo $userName;
    $searchContactFormBlockchain="SELECT * FROM blockchain.blocks WHERE userName LIKE '%".$searchGET."%'OR userName='".$_SESSION['name_login']."'";
    $getContactFromBlockchain =mysqli_query($connect,$searchContactFormBlockchain);
    $totalRow= mysqli_num_rows($getContactFromBlockchain);
    //change the form of button depend on status contact 
    $button='';
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="searchAll.css">
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <!-- Bootstrap core JavaScript -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="vendor-front/jquery/jquery.min.js"></script>
        <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
    <title>Document</title>
</head>
<body style="background-color: #AFC5E9;">
 
  <div class="container">

        <div class="row">
            <div class="col-md-9" id="col-search">
                <h3>search result for <b><?php echo "".$_GET['search-bar']."... ";?></b> </h3>
                <div id="search_result_area">
                    <div class="wrapper-preview">
                        <i class="fas fa-circle-notch  fa-spin  " style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2" id="col-user">
               
                <?php  
                    echo '<img src="../images/'.$userName.'.png" alt="user" id="img-user">
                    </br><p id="img-text"><b>'.$userName.'<b></p>'

                ?>
               
            </div>
            <div class="col" id="col-logout">
                <div class="logo" id="logo">
                    <img src="../images/logoM.png" alt="logo" style="width: 100%; height: 100%;" >
                </div>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" >
                    <li class="nav-item " id="home">
                        <a class="nav-link" id="home" href="profile.php"><i class="fa fa-home fa-2x" ></i> </a>
                    </li>
                    <li class="nav-item active" id="book">
                        <a class="nav-link" href="#"><i class="fa fa-address-book fa-2x"></i><span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item " id="logout">
                        <a class="nav-link " id="logout" href="logout.php"  ><i class="fas fa-sign-out fa-2x"></i></a>
                    </li>
                </ul>
            </div>
            
        </div>
        <div class="row overflow-auto" id="row-result">

        

      
        <?php
            $linkImage='../';
            if ($totalRow>0) {

                while ($row=mysqli_fetch_assoc($getContactFromBlockchain)) 
                {
                    //get  contact status from the function getStatusContact
                    $status=getStatusContact($connect,$userName,$row['userName']);
                    //echo  $row['userName'];
                    if ($status=='panding') {
                        $button='<button type="button" class="btn btn-primary" name="contact_btn" disabled>
                        <i class="fa fa-clock-o" aria-hidden="true" >Panding...</i>
                        </button>';
                    }
                    else if ($status=='reject') {
                        $button='<button type="button" class="btn btn-warning" name="contact_btn">
                         <i class="fa fa-ban" aria-hidden="true">Reject</i>
                        </button>';
                    }
                    else {
                        $button='<button type="button" class="btn btn-primary  contact_req" id="contact_req'.$row['userName'].'"  data-touserid="'.$row['email'].'" data-tousername="'.$row['userName'].'">
                        <i class="fa fa-user-plus" >SEND contact</i>
                        </button>';
                    }
                    $linkImage.=$row['image'];
                    
                    $output.='
                    
                    <div class="wrapper-box" id="wrapper-box">
                        <div class="row" id="row">
                            <div class="col-md-1 col-sm-3 col-xs-3" id="show-request-contact-image">
                              
                             <img src="../images/'.$row['userName'].'.png" alt="user" style="width:50px;height:50px; border-radius: 50%;">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-5">
                                <div class="wrapper-box-title">'.$row['userName'].'</div>
                                <div class="wrapper-box-description"><i>'.$row['email'].'</i></div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-4" align="right">
                                <div class="contact-dis" >
                                   '.$button.'
                                </div>
                            </div>
                        </div></br>
                    </div>
                    </br>
                ';
                }
            }else 
            {
                $output.='
                <div class="wrapper-box">
                <h4 align="center">NO DATA FOUND</h4>
                </div>';
            }
            echo $output;
        
        ?>

      </div>
        
    </div>

  
 
</body>
</html>
<script>
    $(document).ready(function(){
        $(document).on('click','.contact_req',function(){
            var userName= $(this).data('tousername');
            var email=$(this).data('touserid');
            console.log(userName+"---"+email);

            $.ajax({
                url:'contact.php',
                method:'POST',
                data:{userName:userName,email:email},
                // beforeSend: function(){
                //     $('#contact_req'+userName).attr('disabled','disabled');
                //     $('#contact_req'+userName).html('<i class="fa fa-circle-o-notch " ></i>Sending...')
                // },
                success:function(data){
                    alert(data);
                }
            })
        })
        


    })
</script>

<?php
 function getStatusContact ($connect, $from_userName,$to_userName){
    $output='';
    $sqlGetStatusContact="SELECT status_contact FROM contact.contact WHERE from_userName='".$from_userName."' AND to_userName='".$to_userName."'";
    //execute request
    $exeGetStatusContact = mysqli_query($connect, $sqlGetStatusContact);
    $rowGetStatusContact=mysqli_num_rows($exeGetStatusContact);
    if ($rowGetStatusContact>0) {
        
        while($row=mysqli_fetch_assoc($exeGetStatusContact)){
            $output.=$row['status_contact'];
        }
    }
    else {
        
    }
    
    return $output;
 }
?>