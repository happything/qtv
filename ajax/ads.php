<?php  
	$parent_id = $_POST["parent_id"];
	$zip_dir = "../img/cms/ads/".$parent_id."/files/"; 
	if(is_dir($zip_dir)){
		$files = scandir($zip_dir, 1);
		$file = $zip_dir.$files[0];
		if(is_file($file)){
			// assuming file.zip is in the same directory as the executing script.
			
			// get the absolute path to $file
			$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

			$zip = new ZipArchive;
			$res = $zip->open($file);
			if ($res === TRUE) {
			  // extract it to the path we determined above
			  $zip->extractTo($path);
			  $zip->close();

			  $extracted_dir = substr($file, 0, strrpos($file,"."));
			  $index_file = $extracted_dir."/index.php"; //Real index file dir
			  if(is_file($index_file)){
			  	$index_dir = "../ads/".$parent_id; //New index file dir
			  	if(!is_dir($index_dir)) mkdir($index_dir,0777);			
			  	rename($index_file, $index_dir."/index.php"); //Moving index file

			  	$images_dir = $extracted_dir."/img/";	
			  	$images = scandir($images_dir, 1);
			  	if(!is_dir("../css/img/ads")) mkdir("../css/img/ads",0777); //Creating ads images dir

			  	foreach ($images as $image) {			  		
			  		if((trim($image) != "..") && (trim($image) != ".")){ //Ignoring weird characters			  			
			  			rename($images_dir."/".$image, "../css/img/ads/".$image); //Moving images to real dir
			  		}
			  	}

			  	echo 1;

			  } else {
			  	echo -1; //The is not an index.php file
			  }
			} else {
			  echo 0; // It's not zip
			}
		}
	}
?>