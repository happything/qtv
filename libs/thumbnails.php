<?php
class Thumbnails {
    public $img_dir; //temp file
    private $quality = 90; //quality of the image after manage

    function Thumbnails($img_dir,$quality = null) {
        $this->img_dir = $img_dir;
        if(isset($quality)) $this->quality = $quality;          		                
    }        

    //Width redimention
    function width_resize($new_width,$new_name){		        			
        $size = getimagesize($this->img_dir);				
        $width = $size[0];				
        $heigth = $size[1];				
        $type = $size[2];

        if($width > $new_width) {			
            $new_heigth = round(($new_width * $heigth)/$width);			
        } else {                
           $new_heigth = $heigth;
           $new_width = $width;
        }
                           
        $exit = 0;				
        if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 					
        elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }				
        elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); }  					
        else $exit = 1;

        if(!$exit) {						
                $img_resized = imagecreatetruecolor($new_width,$new_heigth);						
                imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$new_width,$new_heigth,$width,$heigth);
                if($type == 1) { return imagegif($img_resized,$new_name,$this->quality); }                   
                elseif($type == 2) { return imagejpeg($img_resized,$new_name,$this->quality); }              
                elseif($type == 3) { return imagepng($img_resized,$new_name,$this->quality); }              								                
        } else {						
                return 0;							
        }        
               
    }
    
    //Height redimention
    function height_resize($new_heigth,$new_name){		        
        $size = getimagesize($this->img_dir);					
        $width = $size[0];				
        $heigth = $size[1];				
        $type = $size[2];			            

        if($heigth > $new_heigth) {				
            $new_width = round(($new_heigth * $width)/$heigth);
        } else {                                
            $new_heigth = $heigth;
            $new_width = $width;            
        }     

        $error = 0;				
        if($type == 1) { $img_tmp = imagecreatefromgif($this->img_dir); } 					
        elseif($type == 2) { $img_tmp = imagecreatefromjpeg($this->img_dir); }				
        elseif($type == 3) { $img_tmp = imagecreatefrompng($this->img_dir); } 					
        else { $error = 1; }					

        if($error == 0) {					
            $img_resized = imagecreatetruecolor($new_width,$new_heigth);					
            imagecopyresampled($img_resized,$img_tmp,0,0,0,0,$new_width,$new_heigth,$width,$heigth);
            if($type == 1) { return imagegif($img_resized,$new_name,$this->quality); }                   
            elseif($type == 2) { return imagejpeg($img_resized,$new_name,$this->quality); }              
            elseif($type == 3) { return imagepng($img_resized,$new_name,$this->quality); }       				            
        } else {					
            return 0;						
        }            
    }
    
    
    //Create a sliced image using the sizes parameters
    function crop($thumbnail_width,$thumbnail_height,$new_name) {		        			
        $size = getimagesize($this->img_dir);					
        $width_orig = $size[0];				
        $height_orig = $size[1];				
        $type = $size[2];			        

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
            if($type == 1) { return imagegif($thumb,$new_name,$this->quality); }                   
            elseif($type == 2) { return imagejpeg($thumb,$new_name,$this->quality); }              
            elseif($type == 3) { return imagepng($thumb,$new_name,$this->quality); }               					
        } else {			
            return 0;					
        }			        				
    }
	
    //Resize image depends of the horientation of the image (Vertical -> Height OR Horizontal -> Width)
	public function custom_resize($new_name,$new_width = null,$new_height = null){			
		$size = getimagesize($this->img_dir);				
		$width = $size[0];				
		$heigth = $size[1];				
		$type = $size[2];			
		
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

?>