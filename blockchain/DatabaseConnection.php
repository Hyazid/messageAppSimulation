<?php

    
    
class DatabaseConnection{
     public function connection()
    {
        $connect = mysqli_connect("localhost", "root", "", "blockchain");
        return $connect;
    }
   

}



?>