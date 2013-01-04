<?php  	
	session_start();
	$return = array();
	if(isset($_POST["imid"])){
		include_once '../config/connection.php';
		$imid = $_POST["imid"];
		$fb_id = $_SESSION["fbid"];

		if(trim($imid)!="" && trim($fb_id) != ""){
			$query = "SELECT id FROM fb_users WHERE fb_id = '".$fb_id."'";
			$result = mysql_query($query,$link);
			if(mysql_num_rows($result)<=0){
				$query = "SELECT id,name,lastname,email FROM users WHERE facebook_id = '".$fb_id."'";
				$result = mysql_query($query,$link);

				if(mysql_num_rows($result)>0){
					$row = mysql_fetch_assoc($result);

					$query = "INSERT INTO fb_users SET name = '".$row["name"]."',
													   lastname = '".$row["lastname"]."',
													   email = '".$row["email"]."',
													   fb_id = '".utf8_decode($fb_id)."',
													   images_id = ".$imid.",
													   register_date = now()";			
					if(mysql_query($query,$link)) echo json_encode(array("code"=>1,"id"=>mysql_insert_id()));
					else echo json_encode(array("code"=>0)); //Error in the insert query								   
				}				
			} else {
				echo json_encode(array("code"=>-1)); //This user was registered earlier
			}	
		} else {
			echo json_encode(array("code"=>-2)); //Some variables are empty
		}
	}
	

?>