<?php
    include('c.php');
    session_start();
    $connect=mysqli_connect("localhost", "root", "");
    $usersession=$_SESSION['name_login'];

    $userToCommunicate= $_POST['to_user_name'];
    $sqlgetMessageFromeSender="SELECT*FROM ".$userToCommunicate.".message_depo WHERE reciver='".$usersession."'ORDER BY date DESC LIMIT 1";
    $sqlgetMessageFromMessageDepo="SELECT * FROM ".$usersession.".message_depo WHERE 
    reciver='" . $userToCommunicate . "' ORDER BY date ASC LIMIT 2";
    $resultGetMessageFromSender=mysqli_query($connect, $sqlgetMessageFromeSender);
    //echo fetch_User_Data_History($userToCommunicate,$usersession,$connect);
        echo getMessagesFromBothSide($usersession,$userToCommunicate, $connect);
     $output = '<ul class="list-unstyled">';
     if ($resultGetMessageFromSender) {
        //echo ("igot something");
         while ($row=mysqli_fetch_assoc($resultGetMessageFromSender)) {
             if ($row['sender']==$userToCommunicate) {
                 $user_name_userCommmunicate = $userToCommunicate;//danger class
             }
             if ($row['reciver']==$usersession) {
                $user_name_usrSession= '<b class="text-success">'.$usersession.'</b>';
             }
           
             $output .= '
             <li style="">
                <div>
                    <p id="userComunicate">
                        
                        '.$user_name_userCommmunicate.'
                    </p>
                        <div id="inc-msg-div">
                                <p id="inc-Message">
                                    '.$row["message"].'
                                </p>
                        </div>
                   

                    <p id="inc-date">
                        '.$row['date'].'
                    </p>
                </div>
                
             </li>
             ';
         }
         $output .= '</ul>';
        echo $output;
     }

     //show the messages i send
     $outputFromMessageDepo='<ul class="list-unstyled">';
     //echo("speak to me dady");
     $resultGetMessageFromeMassageDepo=mysqli_query($connect,$sqlgetMessageFromMessageDepo);
     if ($resultGetMessageFromeMassageDepo) {
        echo ("igot something------");
        
        while ($row=mysqli_fetch_assoc($resultGetMessageFromSender)) {
            echo("ther is something here");
          
            $outputFromMessageDepo .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>form  '.$row['sender'].'--> ------>'.$row['reciver'].' - '.$row["message"].'
            <div align="right">
            - <small><em>'.$row['date'].'</em></small>
            </div>
            </p>
            </li>
            ';
        }
        $outputFromMessageDepo .= '</ul>';
       //echo $outputFromMessageDepo;
       getDataAndHistoryFromBothSide($connect,$usersession,$userToCommunicate);
     }else {
         echo ("something went wrong");
     }




?>
