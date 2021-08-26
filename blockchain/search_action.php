<?php
include('c.php');
    session_start();

    if (isset($_POST["query_result"])) {
        
        $output='';
        $search_array =explode(" ", $_POST["query_result"]);
        $condition = ''; 
        foreach ($search_array as $search) {
            if (trim($search)!='') {
                $condition.="userName LIKE '%".$search."%' OR";
            }
            
        }
        $condition=substr($condition,0,-4);
        

        $query  = "SELECT * FROM blockchain.blocks WHERE ".$condition." AND userName!='".$_SESSION["name_login"]."'";
        $filter_query =$query.'LIMIT '.$start.','.$limit.'';

        $exeQuery =mysqli_query($connect,$query);
        $totalRow =mysqli_num_rows($exeQuery);

        $exeFileterQuery=mysqli_query($connect, $filter_query);

        if ($totalRow>0) {
            while($row=mysqli_fetch_assoc($exeFileterQuery)){
                $output .= '
            <div class="wrapper-box">
                <div class="row">
                    <div class="col-md-1 col-sm-3 col-xs-3">
                    
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-5">
                        <div class="wrapper-box-title">'.$row["userName"].'</div>
                        <div class="wrapper-box-description"><i>From '.$row["email"].'</i></div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-4" align="right">
                        <div class="contact-div">
                            <button type="button" name="requestBtn" class="btn btn-primary requestBtn" 
                            data-userName="'.$row['userName'].'">
                            <i class="fa fa-user-plus" >SEND contact</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        ';

            }
        } else {
            $output='
                <div class="wrapper-box">
                <h4 align="center">NO DATA FOUND</h4>
                </div>
            
            ';
        }
       echo $output;
        

        


    }

?>