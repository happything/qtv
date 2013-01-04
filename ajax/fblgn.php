<?php  
	session_start();
	include_once '../config/connection.php';
	$fbid = $_POST["fbid"];
	$name = $_POST["name"];
	$gender = $_POST["gender"];
	$email = $_POST["email"];
	$login = $_POST["login"];

	if($gender == "male") $gender = 1;
	else $gender = 2;

	$query = "SELECT id FROM users WHERE facebook_id = '".utf8_decode($fbid)."'";
	$result = mysql_query($query,$link);
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_assoc($result);
		$_SESSION["qtvusrid"] = $row["id"]; 
		$_SESSION["fbid"] = $fbid;
		echo 1; //You can't register
	} else {
		if($login){
			$query = "INSERT INTO users SET name = '".utf8_decode($name)."',
											email = '".utf8_decode($email)."',
											facebook_id = '".utf8_decode($fbid)."',
											gender = ".utf8_decode($gender).",
											user_types_id = 4,
											password = '0000',
											enabled = 1,
											date = now(),
											orden = 1000";											
			if(mysql_query($query,$link)){
				$_SESSION["qtvusrid"] = mysql_insert_id(); 
				$_SESSION["fbid"] = $fbid;
				echo 1;													
			} else {
				echo -1;
				//echo mysql_error(); //Can't save
			}			
		} else echo 0; //You can register		
	}
	mysql_close($link);	
?>