<?php
 include("c.php");
 session_start();
 
 $username= $_SESSION["name_login"];
 //get request sender
 //get request reciver
 //get contact from blockchain add a button to push to add
 $value=0;
 $sqlGetContactFromBlockchain="SELECT * FROM blockchain.blocks";
 $getContactFromBlockchain=mysqli_query($connect, $sqlGetContactFromBlockchain);
 $rowContactFromBlockchain=mysqli_num_rows($getContactFromBlockchain);
    if(isset($_POST['query'])){
        $search_query= preg_replace('#[^a-z 0-9?!]#i','',$_POST['query']);//remove all special caracter an space and replace it with ''
        $search_array= explode(" ", $search_query);
        $replace_array= array_map('wrapTag', $search_array);
        $condition="";
        foreach ($search_array as $search) {
            if (trim($search)!='') {
                $condition.="userName LIKE '%".$search."%'OR ";
            }
        }
        $condition= substr($condition, 0,-4);
        $output='<div class="list-group">';
        $query ="SELECT * FROM blockchain.blocks WHERE ".$condition."AND userName= '".$username."' LIMIT 11";
        $getUserNameForContact=mysqli_query($connect,$query);
        $resultContactName=mysqli_num_rows($getContactFromBlockchain);
        if ($resultContactName>0) {
            while ($row=mysqli_fetch_assoc($getContactFromBlockchain)) {
                $temp_text=$row['userName'];
                $temp_text_email=$row['email'];
                $temp_text=str_ireplace($search_array,$replace_array,$temp_text);
                $output.='<a href="#" class="list-group-item" >'.$temp_text.'
                </br>
                '.$row['email'].'</br>
                
                </a>
                <div class="text-right">
                
                </div>
                ';
                


            }
        }
        else {
            $output.='<a href="#" class="list-group-item">NO result Found</a>';

        }
        $output.='</div>';
        echo $output;


        
        
    }else {
        echo(" igot nothing");
    }



//  $output='';
//  if ($rowContactFromBlockchain>0) {
//      while ($row=mysqli_fetch_assoc($getContactFromBlockchain)) {
//         // echo ''.$row['userName'].''.$row['email'].''.$row['publicKey'].'';
//         $output.='<option value='.$value++.' id='.$row['userName'].'>
//         <ul class="list-unstyled">
//         <p>'.$row['userName'].'</br>
//         '.$row['email'].'

//         </p>
        
//         </ul>
//         </option>';
//      }
//  }



//  $output.='';
//  echo $output;


 
function wrapTag($argument){
    return '<b>'.$argument.'</b>';
}

?>