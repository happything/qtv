<?php  
	$link = mysql_connect("localhost","quetevalgan","ktvmx");
	mysql_select_db("qtv");

	$main_folder  = "galerias/fotos/albums/antros/";
    if(is_dir($main_folder)){    	
        include_once 'libs/thumbnails.php';                    

        $folders = scandir($main_folder, 1);
        foreach ($folders as $folder) {
        	$album_id = -1;
        	//read the album folders
        	if(is_dir($folder)){
        		//read the albums images
        		$files = scandir($folder,1);        		
        		foreach ($files as $file) {
        			if($album_id == -1){
        				$img_name = $file; //File name
        				$query = "SELECT g_id,g_description,g_title,g_originationTimestamp as date
        						    FROM gal_fileSystemEntry fse 
        					   LEFT JOIN gal_childEntity ON parent_id = fse.g_id 
        					   LEFT JOIN gal_item i ON i.g_id = fse.g_id 
        						   WHERE g_pathComponent = '$img_name'";
        				$result = mysql_query($query,$link);
        				$row = mysql_fetch_assoc($result);

        				$album_date = date("Y-m-d",$row["date"]);

        				$query = "INSERT INTO galleries 
        								  SET title = '".utf8_decode($row["g_title"])."',
        								      description = '".utf8_decode($row["g_description"])."',
        								      date = '".$album_date."', 
        								      galleries_type_id = 1,
        								      enabled = 1";	

        				$album_id = mysql_insert_id($link);				      	   
        			}

        			$default_dir = "img/cms/galleries/";
			        mkdir($default_dir.$album_id,0777);
			        mkdir($default_dir.$album_id."/thumbnails",0777);
			        mkdir($default_dir.$album_id."/files",0777);

			        foreach ($files as $image) {                              
			            if((trim($image) != "..") && (trim($image) != ".")){ //Ignoring weird characters 
			                $query = "INSERT INTO images SET title = '".utf8_decode($image)."',
			                                                 section = 'galleries',
			                                                 parent_id = ".$album_id.",
			                                                 orden = 1000,
			                                                 enabled = 1";  
			                echo mysql_error($link);                                                                     
			                if(mysql_query($query,$link)){ 
			                    if(is_file("temp_galleries/".$folder."/".$image)){
			                        $thumbnail = new Thumbnails($main_folder.$folder."/".$image,100);
			                        $new_default_dir = $default_dir.$album_id."/thumbnails/";

			                        @mkdir($new_default_dir."thumb_small",0777);
			                        $thumbnail->crop(50,50,$new_default_dir."thumb_small/".$image);

			                        @mkdir($new_default_dir."thumb_big",0777);
			                        $thumbnail->crop(250,250,$new_default_dir."thumb_big/".$image);

			                        @mkdir($new_default_dir."thumb_gallery",0777);
			                        $thumbnail->width_resize(640,$new_default_dir."thumb_gallery/".$image);

			                        @mkdir($new_default_dir."thumb_album",0777);
			                        $thumbnail->crop(150,110,$new_default_dir."thumb_album/".$image);

			                        @mkdir($new_default_dir."thumb_banner",0777);
			                        $thumbnail->crop(487,190,$new_default_dir."thumb_banner/".$image);    
			                    }                            
			                }    
			            }    
			        }
        		}
        	}
        }
    }
?>		