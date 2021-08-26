<?php
    include('c.php');
    session_start();
    $connect=mysqli_connect("localhost", "root", "");
    $usersession=$_SESSION['name_login'];

    $userToCommunicate= $_POST['to_user_name'];
    $sqlgetMessageFromeSender="SELECT*FROM ".$userToCommunicate.".message_depo WHERE reciver='".$usersession."'ORDER BY date DESC LIMIT 3";
    $resultGetMessageFromSender=mysqli_query($connect, $sqlgetMessageFromeSender);
    //echo fetch_User_Data_History($userToCommunicate,$usersession,$connect);
     $output = '<ul class="list-unstyled">';
     if ($resultGetMessageFromSender) {
        echo ("igot something");
         while ($row=mysqli_fetch_assoc($resultGetMessageFromSender)) {
             if ($row['sender']==$userToCommunicate) {
                 $user_name_userCommmunicate = '<b class="text-danger">'.$userToCommunicate.'</b>';
             }
             if ($row['reciver']==$usersession) {
                $user_name_usrSession= '<b class="text-success">'.$usersession.'</b>';
             }
           
             $output .= '
             <li style="border-bottom:1px dotted #ccc">
             <p>form  '.$user_name_userCommmunicate.'--> ------'.$user_name_usrSession.' - '.$row["message"].'
             <div align="right">
             - <small><em>'.$row['date'].'</em></small>
             </div>
             </p>
             </li>
             ';
         }
         $output .= '</ul>';
        echo $output;
     }



?>
