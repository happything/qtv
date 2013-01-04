<?php
class Image {
    private $img_dir; 	
    private $max_size;   	
    private $file_size;
    
    function Image($img_dir,$max_size,$file_size) {
        $this->img_dir = $img_dir;          		
        $this->max_size = $max_size;      		
        $this->file_size = $file_size;        
    }
        
    //Redimenci�n de una imagen por medio del ancho    
    
    function resize_width($new_width,$new_name){		
        $size = $this->file_size;		
        if($size < $this->max_size) {			
            $size = getimagesize($this->img_dir);				
            $width = $size[0];				
            $heigth = $size[1];				
            $type = $size[2];

            if(is_file($new_name)) {					
                    //unlink($new_name);					
            }

            if($width > $new_width) {			
                $new_heigth = round(($new_width * $heigth)/$width);			
                $exit = 0;				
                if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 					
                elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }				
                elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); }  					
                else $exit = 1;

                if(!$exit) {						
                        $img_resized = imagecreatetruecolor($new_width,$new_heigth);						
                        imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$new_width,$new_heigth,$width,$heigth);           								
                        return imagejpeg($img_resized,$new_name,90);						
                } else {						
                        return 0;							
                }
            } else {				
                $error = 0;				
                if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 				
                elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }			
                elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); } 				
                else { $error = 1; }

                if(!$error) {					
                        $img_resized = imagecreatetruecolor($width,$heigth);									
                        imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$width,$heigth,$width,$heigth);				
                        return imagejpeg($img_resized,$new_name,90);     						
                } else {					
                        return 0;						
                }				
            }				
        }        
    }
    
    //Redimenci�n de una imagen por medio de la altura
    
    function resize_heigth($new_heigth,$new_name){		
        $size = $this->file_size;		
        if($size < $this->max_size) {        
           $size = getimagesize($this->img_dir);					
            $width = $size[0];				
            $heigth = $size[1];				
            $type = $size[2];			
            if(is_file($new_name)) {					
                unlink($new_name);					
            }

            if($heigth >= $new_heigth) {				
                $new_width = round(($new_heigth * $width)/$heigth);			
                $error = 0;				
                if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 					
                elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }				
                elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); } 					
                else { $error = 1; }					
                if($error == 0) {					
                    $img_resized = imagecreatetruecolor($new_width,$new_heigth);					
                    imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$new_width,$new_heigth,$width,$heigth);				
                    return imagejpeg($img_resized,$new_name,90);					
                } else {					
                    return 0;						
                }
            } else {								
                $error = 0;						
                if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 				
                elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }			
                elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); } 			
                else { $error = 1; }				
                if(!$error) {					
                        $img_resized = imagecreatetruecolor($width,$heigth);									
                        imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$width,$heigth,$width,$heigth);
                        return imagejpeg($img_resized,$new_name,90);     						
                } else {					
                        return 0;						
                }				
            }       			
        }        
    }
    
    
    //Cortar imagenes con un tama�o fijo en posiciones predise�adas
   
    function crop($thumbnail_width,$thumbnail_height,$new_name) {		
        $size = $this->file_size;			
        if($size < $this->max_size) {			
            $size = getimagesize($this->img_dir);					
            $width_orig = $size[0];				
            $height_orig = $size[1];				
            $type = $size[2];			
            if(is_file($new_name)) {						
                    unlink($new_name);						
            }

            $error = 0;			
            if($type == 1) { $myImage = imagecreatefromgif($this->img_dir); } 					
            elseif($type == 2) { $myImage = imagecreatefromjpeg($this->img_dir); }				
            elseif($type == 3) { $myImage = imagecreatefrompng($this->img_dir); } 					
            else { $error = 1; } 					
            if(!$error) {				
                $ratio_orig = $width_orig/$height_orig;			   
                if ($thumbnail_width/$thumbnail_height > $ratio_orig) {					
                   $new_height = $thumbnail_width/$ratio_orig;				   
                   $new_width = $thumbnail_width;				   
                } else {					
                   $new_width = $thumbnail_height*$ratio_orig;				   
                   $new_height = $thumbnail_height;				   
                }

                $x_mid = $new_width/2;  //horizontal middle				
                $y_mid = $new_height/2; //vertical middle			   
                $process = imagecreatetruecolor(round($new_width), round($new_height));       			   
                imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);				
                $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);				
                imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);			
                return imagejpeg($thumb,$new_name,90);					
            } else {			
                return 0;					
            }			
        } else {			
            return 0;				
        }					
    }
	
	 public function resize_custom($new_width = null,$new_height = null,$new_name){
		
		$size = $this->file_size;
		
		if($size < $this->max_size) {
			
				$size = getimagesize($this->img_dir);
				
				$width = $size[0];
				
				$heigth = $size[1];
				
				$type = $size[2];
			
			if(is_file($new_name)) {
					
				unlink($new_name);
					
			}
			
			if($new_width > $width) {
					
					$exit = 0;
				
					if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 
					
					elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }
				
					elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); }  
					
					else $exit = 1;
					
					if(!$exit) {
						
						$img_resized = imagecreatetruecolor($width,$heigth);
						
						imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$width,$heigth,$width,$heigth);           		
						
						return imagejpeg($img_resized,$new_name,90);
						
					} else {
						
						return 0;	
						
					}
				
			} else if($width >= $heigth) { // If the new image has a Horizontal orientation
				
				return $this->resize_width($new_width,$new_name);	
				
			} elseif($heigth > $width) { // If the new images has a Vertical Orientation
				
				return $this->resize_heigth($new_height,$new_name);
				
			} 
			
		}
        
    }

}

?>