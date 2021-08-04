<?php




class User 
{
     private $index;
	 private $userName;
     private $name;
	 private $email;
	 private $user_verification_code;
     private $date;
     private $publickey;
     private $user_profile;  
     public $connect;
     public function __construct()
     {
        require_once('DatabaseConnection.php');
        $datebase= new DatabaseConnection;
        $this->connect = $datebase->connection();

         echo"hello from ----";
     }
     function setIndex($index){$this->index = $index;}
	 function getIndex(){return $this->index;}
     function setpublicKey($publickey){$this->publickey = $publickey;}
	 function getpublickey(){return $this->publickey;}
     function setDate($date){$this->data = $date;}
	 function getDate(){return $this->date;}
     function setName($name){$this->name = $name;}
	 function getName(){return $this->name;}
     function setUserName($userName){$this->userName = $userName;}
	 function getUserName(){return $this->userName;}
     function setEmail($email){$this->email = $email;}
	 function getEmail(){return $this->email;}
     function setuser_verification_code($user_verification_code){$this->user_verification_code= $user_verification_code;}
	 function getuser_verification_code(){return $this->user_verification_code;}
     function setuser_profile($user_profile){$this->user_profile = $user_profile;}
     function getuser_profile(){return $this->user_profile;}

     function make_avatar($character)
	 {
	     $path = "images/". time() . ".png";
	 	$image = imagecreate(200, 200);
	 	$red = rand(0, 255);
	 	$green = rand(0, 255);
	 	$blue = rand(0, 255);
	     imagecolorallocate($image, $red, $green, $blue);  
	     $textcolor = imagecolorallocate($image, 255,255,255);
	     //imagettftext($image, 100, 0, 55, 150, $textcolor,'fonts/arial.TTF' , $character);
         imagestring($image, 50,100,100,$character,$textcolor);
	     imagejpeg($image, $path);
	     imagedestroy($image);
	    return $path;
	}
    function getDataByEmail(){
        $query = "
		SELECT * FROM blocks 
		WHERE name = '.$this->name.'";
        $statement = $this->connect->query($query);
        //$statement->bind_Param('s', $this->email);
        if($statement)
		{
			
            echo'datafetched';
            $user_data=$statement->fetch_assoc();
            
            echo "theris a data--.".$user_data;

            return $user_data;
		}
        else {
            return "there is a n error";
        }
    }
    function saveData(){
        $query = "
		INSERT INTO blocks(date, name, userName, publicKey, , email, user_verification_code,user_profile) 
		VALUES (?,?, ?, ?, ?,?,?)
		";
		$statement = $this->connect->prepare($query);
        $statement->bind_Param('sssssss', $this->date,$this->name,$this->userName,$this->publicKey,$this->email,$this->user_verification_code,$this->user_profile);
		
        if($statement->execute())
		{
            echo("true----->>>>");
			return true;
		}
		else
		{
            echo("noooooooooooo");
			return "something went wrong";
		}

		

		

		
    }
}

?>
	
    