<?php
    include('c.php');
    session_start();
    $output = '<ul class="list-unstyled">';
    $usersession= $_SESSION['name_login'];
    $reciver= $_POST['to_user_name'];//we will get messagefrom his messagedepo

    
    $sqlGetMessageFromReciverToUsersession="SELECT * FROM ".$reciver.".message_depo WHERE reciver='".$usersession."' ORDER BY date DESC";
    $getMessageFromeReciverToUsersession=mysqli_query($connect,$sqlGetMessageFromReciverToUsersession);
    $rowGetMessageFRromReciver=mysqli_num_rows($getMessageFromeReciverToUsersession);
    if($rowGetMessageFRromReciver>0){
        while($row=mysqli_fetch_assoc($getMessageFromeReciverToUsersession)){
            $this_to_usersession="";
            if ($row['reciver']==$usersession) {
                $this_to_usersession='<b class="text-danger">'.$row['sender'].'</b>';
            }else{}

            ///donst foget to decrypte message
            $output .= '
                <li style="border-bottom:1px dotted #ccc">
                <p> Feom:'.$this_to_usersession.' -><b class="text-success"> '.$row['reciver'].'</b> :'.$row["message"].'
                <div align="right">
                   - <small><em>'.$row['date'].'</em></small>
                   </div>
                </p>
                </li>
                ';
        }
        $output .= '</ul>
        <button type="button"  class="btn btn-danger  hide-mes">Hide</button>
        ';
        echo $output;
    }
    


?>
<script>
    $(document).ready(function(){

        $(".hide-mes").click(function(){
            alert("hhhhhh")
            $("#history").hide(500);
        })
    })
</script>