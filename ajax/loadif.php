<?php
	if(isset($_POST["type"])){
		$type = $_POST["type"];	
		if($type=="get"){
			$folder = $_POST["fld"];
			$return = array();
			$return["images"] = array();
			if(is_dir("../temp_galleries/".$folder)) {
				$return["error"] = 0;
				$files = scandir("../temp_galleries/".$folder);
				foreach ($files as $image) {			  		
			  		if((trim($image) != "..") && (trim($image) != ".")){ //Ignoring weird characters			  			
			  			array_push($return["images"], $image);
			  		}
			  	}
			} else {
				$return["error"] = 1;
			}

			echo json_encode($return);	
		} else if($type == "upload"){
			include_once '../config/connection.php';
			include_once '../libs/thumbnails.php';
			//Ajax variables -----
			$imgs_arr = $_POST["imgs"];
			$album_id = $_POST["albid"];
			$folder = $_POST["fld"];			
			//Set variables ------					
			$default_dir = "../img/cms/galleries/";
			$new_default_dir = $default_dir.$album_id."/thumbnails/";
			$errors = array();

			//Upload THE images
			for($i=0; $i<count($imgs_arr); $i++){
				$image = $imgs_arr[$i];				
                $query = "INSERT INTO images SET title = '".utf8_decode($image)."',
                                                 section = 'galleries',
                                                 parent_id = ".$album_id.",
                                                 orden = 1,
                                                 enabled = 1";  

				chmod("../temp_galleries/".$folder, 0777); 
                if(mysql_query($query,$link)){ 
                    if(is_file("../temp_galleries/".$folder."/".$image)){
                    	$error = 0;
                        $thumbnail = new Thumbnails("../temp_galleries/".$folder."/".$image,100);                       

                        @mkdir($new_default_dir."thumb_small",0777);
                        if(!$thumbnail->crop(50,50,$new_default_dir."thumb_small/".$image)) $error = 1;

                        @mkdir($new_default_dir."thumb_big",0777);
                        if(!$thumbnail->crop(250,250,$new_default_dir."thumb_big/".$image)) $error = 1;

                        @mkdir($new_default_dir."thumb_gallery",0777);
                        if($thumbnail->width_resize(640,$new_default_dir."thumb_gallery/".$image)) $error = 1;

                        @mkdir($new_default_dir."thumb_album",0777);
                        if(!$thumbnail->crop(150,110,$new_default_dir."thumb_album/".$image)) $error = 1;

                        @mkdir($new_default_dir."thumb_banner",0777);
                        if(!$thumbnail->crop(487,190,$new_default_dir."thumb_banner/".$image)) $error = 1;

                        copy("../temp_galleries/".$folder."/".$image, $default_dir.$album_id."/files/".$image);

                        array_push($errors, $error);
                    }                            
                } else {
                	array_push($errors, 1); //Query error
                }
			}

	        mysql_close($link);                
	        echo json_encode($errors);
		}	
	} 
?>