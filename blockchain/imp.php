<?php
    include('c.php');
    session_start();
    $connect=mysqli_connect("localhost", "root", "");
    $usersession=$_SESSION['name_login'];

    $userToCommunicate= $_POST['to_user_name'];
    $sqlgetMessageFromeSender="SELECT*FROM ".$userToCommunicate.".message_depo WHERE reciver='".$usersession."'ORDER BY date DESC";
    $resultGetMessageFromSender=mysqli_query($connect, $sqlgetMessageFromeSender);
    $output = '<ul>';
    if ($resultGetMessageFromSender) {
        echo ("igot something");
        while ($row=mysqli_fetch_assoc($resultGetMessageFromSender)) {
           
            $output .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>form  '.$row['sender'].'-->'.$row["reciver"].' - '.$row["message"].'
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
