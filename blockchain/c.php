<?php



function connectToCreate(){
     $connectForCreating=mysqli_connect("localhost", "root", "");
     return $connectForCreating;
}
$connect=mysqli_connect("localhost", "root", "");

function connectToUserDate($usernameDatabase)
{
    $connectToDBUser=mysqli_connect("localhost", "root", "",$usernameDatabase);
    return $connectToDBUser;

}
//sender====>usersession
//fetch userdata to get response from the other side
function fetch_User_Data_History($userSession, $reciver, $connect){
    




    $sqlgetMessageFromeSender="SELECT*FROM ".$reciver.".message_depo WHERE reciver='".$userSession."'ORDER BY date DESC LIMIT 1";
    
    $resultGetMessageFromSender=mysqli_query($connect, $sqlgetMessageFromeSender);

    $output2 = '<ul class="list-unstyled">';
    if ($resultGetMessageFromSender) {
       //echo ("igot something");
        while ($row=mysqli_fetch_assoc($resultGetMessageFromSender)) {
            if ($row['sender']==$reciver) {
                $user_name_userCommmunicate = $reciver;//danger class
            }
            if ($row['reciver']==$userSession) {
               $user_name_usrSession= '<b class="text-success">'.$userSession.'</b>';
            }
          
            $output2 .= '
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
        $output2 .= '</ul>';
       echo $output2;
    }

    
    //////////////
    $output = '<ul class="list-unstyled">';
    $sqlGetMessageHistory = 
    "SELECT * FROM ".$userSession.".message_depo WHERE 
    reciver='" . $reciver . "' ORDER BY date DESC LIMIT 1";
    $sqlGETMessagefromReciver=
    "SELECT * FROM ".$userSession.".message_depo WHERE reciver='". $userSession ."'ORDER BY date DESC LIMIT 1" ;
    $getMessageHistoryFromDB=
    mysqli_query($connect,$sqlGetMessageHistory);
    $getMessageFromSender=mysqli_query($connect,$sqlGETMessagefromReciver);
    $resultGetMessageFromDB=mysqli_num_rows($getMessageHistoryFromDB);
    if ($resultGetMessageFromDB>0) {
        while ($row=mysqli_fetch_assoc($getMessageHistoryFromDB)) 
        {
            $this_user_name = '';
            if($row["sender"] == $userSession){
               
               $this_user_name = '<b class="text-success">You</b>';
               echo($row['reciver']);

            }
            else {
                # code...yazid please don forget this part its about the entring message 
                
                $this_user_name = '<b class="text-danger">'.getOtherSideUserName($row['reciver'],$connect).'</b>';
                
            }
            $output .= '
                <li style="border-bottom:1px dotted #ccc">
                <p>'.$this_user_name.' -----> '.$row['reciver'].'---->'.$row["message"].'
                <div align="right">
                   - <small><em>'.$row['date'].'</em></small>
                   </div>
                </p>
                </li>
                ';
          }

          $output .= '</ul>';
         return $output;

    }
    ////////////////////////////////
    $output1 = '<ul class="list-unstyled">';
    while ($row=mysqli_fetch_assoc($getMessageFromSender)) 
        {
            $this_user_name = '';
            if($row["sender"] == $reciver){
               
               $this_user_name = '<b class="text-success">You</b>';
               echo($row['reciver']);

            }
            else {
                # code...yazid please don forget this part its about the entring message 
                
                $this_user_name = '<b class="text-danger">'.getOtherSideUserName($row['reciver'],$connect).'</b>';
                
            }
            $output1 .= '
                <li style="border-bottom:1px dotted #ccc">
                <p>'.$this_user_name.' -----> '.$row['reciver'].'---->'.$row["message"].'
                <div align="right">
                   - <small><em>'.$row['date'].'</em></small>
                   </div>
                </p>
                </li>
                ';
          }

          $output1 .= '</ul>';
         return$output1;


    

}


//get other user to display then  in other color from 
//
function getMessagesFromBothSide($userSession,$reciver,$connect){
    // $query='SELECT * FROM'.$userSession.'.message_depo pr  JOIN '.$reciver.'.message_depo gr ON pr.sender=gr.reciver'; 

    // $result =mysqli_query($connect,$query);
    // $resultRow=mysqli_num_rows($result);
    // if ($resultRow>0) {

    //     echo "bbbbbbbbbbbbbbbbbbbbbbbbbbbbb";
    //     # code...
    // }
    // else {
    //     echo "something wrong";
    // }
}





function getOtherSideUserName($UserName,$connect){
    $query = "SELECT userName FROM blockchain.blocks WHERE userName='". $UserName ."'";
    $queryGetOtherSideUserName=mysqli_query($connect,$query);
    $rowResult=mysqli_num_rows($queryGetOtherSideUserName);
    if ($rowResult>0) {
        echo("igot other username");
        while ($row=mysqli_fetch_assoc($queryGetOtherSideUserName)) {
            return $row['userName'];
        }
    }
}



function getDataAndHistoryFromBothSide($connect,$userSession,$reciver){
    $query="SELECT ".$userSession.".message_depo.sender,".$userSession.".message_depo.message,".$userSession.".message_depo.reciver,".$userSession.".message_depo.date 
    FROM ".$userSession.".message_depo WHERE ".$userSession.".message_depo.reciver='".$reciver."' 
    UNION 
    SELECT ".$reciver.".message_depo.sender,".$reciver.".message_depo.message,".$reciver.".message_depo.reciver,".$reciver.".message_depo.date 
    FROM ".$reciver.".message_depo WHERE ".$reciver.".message_depo.reciver='".$userSession."' ORDER BY `date` ASC";
    $exequery=mysqli_query($connect,$query);
    $queryRow=mysqli_num_rows($exequery);
    if ($queryRow>0) {
        while ($row=mysqli_fetch_assoc($exequery)) {
            if ($row['sender']==$userSession) {
                echo '<b style="color:blue;">'.$row['sender'].'</b>--<p style="color:green;">'.$row['reciver'].'</p>--'.$row['message'].''.$row['date'].'</br>';
                echo "*******************************</br>";
            }
            else {
                if ($row['sender']==$reciver) {
                    echo '<b style="color:red;">'.$row['sender'].'</b>--'.$row['reciver'].'--'.$row['message'].''.$row['date'].'</br>';
                    echo "*******************************</br>";
                }
            }
            
        }
    }
}

?>