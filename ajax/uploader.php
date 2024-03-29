<?php
/*
 * jQuery File Upload Plugin PHP Example 5.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);

class UploadHandler
{
    private $options;
    private $seccion;
    private $record;
    
    function __construct($options=null, $seccion = null, $record = null) {
        if($seccion)
            $this->seccion = $seccion;
        if($record)
            $this->record = $record;
        
        if($seccion=="ads"){
            $this->options = array(
                'script_url' => $this->getFullUrl().'/ajax/'.basename(__FILE__),
                'upload_dir' => $_SERVER['DOCUMENT_ROOT'].'/img/cms/files/',
                'upload_url' => $this->getFullUrl().'/img/cms/files/',
                'param_name' => 'archivos',
                // The php.ini settings upload_max_filesize and post_max_size
                // take precedence over the following max_file_size setting:
                'max_file_size' => 4000000,
                'min_file_size' => 0,
                'accept_file_types' => '/.+$/i',
                'max_number_of_files' => null,
                // Set the following option to false to enable non-multipart uploads:
                'discard_aborted_uploads' => true,
                // Set to true to rotate images based on EXIF meta data, if available:
                'orient_image' => false
            );    
        }else{
            $this->options = array(
                'script_url' => $this->getFullUrl().'/ajax/'.basename(__FILE__),
                'upload_dir' => $_SERVER['DOCUMENT_ROOT'].'/img/cms/files/',
                'upload_url' => $this->getFullUrl().'/img/cms/files/',
                'param_name' => 'archivos',
                // The php.ini settings upload_max_filesize and post_max_size
                // take precedence over the following max_file_size setting:
                'max_file_size' => 4000000,
                'min_file_size' => 10000,
                'accept_file_types' => '/.+$/i',
                'max_number_of_files' => null,
                // Set the following option to false to enable non-multipart uploads:
                'discard_aborted_uploads' => true,
                // Set to true to rotate images based on EXIF meta data, if available:
                'orient_image' => false,
                'image_versions' => array(
                    // Uncomment the following version to restrict the size of
                    // uploaded images. You can also add additional versions with
                    // their own upload directories:
                    /*'large' => array(
                        'upload_dir' => dirname(__FILE__).'/files/',
                        'upload_url' => dirname($_SERVER['PHP_SELF']).'/files/',
                        'max_width' => 1920,
                        'max_height' => 1200
                    ),*/
                    'thumbnail' => array(
                        'upload_dir' => $_SERVER['DOCUMENT_ROOT'].'/img/cms/thumbnails/',
                        'upload_url' => $this->getFullUrl().'/img/cms/thumbnails/',
                        'max_width' => 160,
                        'max_height' => 160,
                        'width' => 160,
                        'height' => 160,
                        //True to crop image, false to scale image
                        'crop_image' => true,
                    )
                )
            );    
        }

        if (is_array($options)) {
            $this->options = $this->array_replace_recursive($this->options, $options);
        }
    }
    
    function array_replace_recursive(array &$original, array &$array) {
        $arrays = func_get_args();
        $return = array_shift($arrays);

        foreach ($arrays as &$array) {
          foreach ($array as $key => &$value) {
            if (isset($original[$key]) && is_array($original[$key]) && is_array($value)) {
              $return[$key] = $this->array_replace_recursive($return[$key], $value);
            } else {
              $return[$key] = $value;
            }
          }
        }
        return $return;
      }
    
    function getFullUrl() {
      	return
        		(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
        		(isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
        		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
        		(isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
        		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT'])))/*.
        		substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'))*/;
    }
    
    private function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'].$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'].rawurlencode($file->name);
            foreach($this->options['image_versions'] as $version => $options) {
                if (is_file($options['upload_dir'].$file_name)) {
                    $file->{$version.'_url'} = $options['upload_url']
                        .rawurlencode($file->name);
                }
            }
            $file->delete_url = $this->options['script_url']
                .'?file='.rawurlencode($file->name)."&seccion=".$this->seccion.'&insert_id='.$this->record;
            $file->delete_type = 'DELETE';
            return $file;
        }
        return null;
    }
    
    private function get_file_objects() {
        return array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            scandir($this->options['upload_dir'])
        )));
    }
       
    private function create_cropped_image($file_name, $options){
        $file_path = $this->options['upload_dir'].$file_name;
        $new_file_path = $options['upload_dir'].$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if(!$img_width || !$img_height){
            return false;
        }
        $ratio = $img_width / $img_height;
        if(($options['width'] / $options['height']) > $ratio){
            $new_height = $options['width'] / $ratio;
            $new_width = $options['width'];
        }else{
            $new_width = $options['height'] * $ratio;
            $new_height = $options['height'];
        }
        $x_mid = $new_width / 2;
        $y_mid = $new_height / 2;
        $new_img = @imagecreatetruecolor(round($new_width), round($new_height));
        $thumb = @imagecreatetruecolor($options['width'], $options['height']);
        switch(strtolower(substr(strrchr($file_name, '.'), 1))){
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagecolortransparent($thumb, @imagecolorallocate($thumb, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                @imagecolortransparent($thumb, @imagecolorallocate($thumb, 0, 0, 0));
                @imagealphablending($thumb, false);
                @imagesavealpha($thumb, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                break;
            default:
                $src_img = $image_method = null;
        }
        @imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);
        $success = $src_img && @imagecopyresampled($thumb, $new_img, 0, 0, ($x_mid-($options['width']/2)), ($y_mid-($options['height']/2)), $options['width'], $options['height'], $options['width'], $options['height']) && $write_image($thumb, $new_file_path);
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }

    private function create_scaled_image($file_name, $options) {
        $file_path = $this->options['upload_dir'].$file_name;
        $new_file_path = $options['upload_dir'].$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale > 1) {
            $scale = 1;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                break;
            default:
                $src_img = $image_method = null;
        }
        $success = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }
    
    private function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
            ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
            ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }
    
    private function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.'.$matches[1];
        }
        return $file_name;
    }

    private function orient_image($file_path) {
      	$exif = exif_read_data($file_path);
      	$orientation = intval(@$exif['Orientation']);
      	if (!in_array($orientation, array(3, 6, 8))) { 
      	    return false;
      	}
      	$image = @imagecreatefromjpeg($file_path);
      	switch ($orientation) {
        	  case 3:
          	    $image = @imagerotate($image, 180, 0);
          	    break;
        	  case 6:
          	    $image = @imagerotate($image, 270, 0);
          	    break;
        	  case 8:
          	    $image = @imagerotate($image, 90, 0);
          	    break;
          	default:
          	    return false;
      	}
      	$success = imagejpeg($image, $file_path);
      	// Free up memory (imagedestroy does not delete files):
      	@imagedestroy($image);
      	return $success;
    }
    
    private function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
            $file_path = $this->options['upload_dir'].$file->name;
            $append_file = !$this->options['discard_aborted_uploads'] &&
                is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    if($this->seccion == "ads"){
                        move_uploaded_file($uploaded_file, $file_path);    
                        return;
                    } else {
                        move_uploaded_file($uploaded_file, $file_path);    
                    }
                    
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen('php://input', 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = filesize($file_path);
            if ($file_size === $file->size) {
            		if ($this->options['orient_image']) {
            		    $this->orient_image($file_path);
            		}
                $file->url = $this->options['upload_url'].rawurlencode($file->name);
                foreach($this->options['image_versions'] as $version => $options) {
                    if(isset($options['crop_image'])){
                        switch ($options['crop_image']) {
                            case false:
                                if ($this->create_scaled_image($file->name, $options)) {
                                    $file->{$version.'_url'} = $options['upload_url']
                                        .rawurlencode($file->name);
                                }
                                break;
                            default:
                                if ($this->create_cropped_image($file->name, $options)) {
                                    $file->{$version.'_url'} = $options['upload_url']
                                        .rawurlencode($file->name);
                                }
                                break;
                        }    
                    } else {
                        if ($this->create_cropped_image($file->name, $options)) {
                            $file->{$version.'_url'} = $options['upload_url']
                                .rawurlencode($file->name);
                        }
                    }                   
                }
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
            $file->delete_url = $this->options['script_url']
                .'?file='.rawurlencode($file->name).'&seccion='.$this->seccion.'&insert_id='.$this->record;
            $file->delete_type = 'DELETE';
        } else {
            $file->error = $error;
        }
        return $file;
    }
    
    public function get() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        //echo json_encode($info);
    }
    
    public function post() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete();
        }
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index]
                );
            }
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            $info[] = $this->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                        isset($upload['name']) : null),
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                        isset($upload['size']) : null),
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                        isset($upload['type']) : null),
                isset($upload['error']) ? $upload['error'] : null
            );
        }
        
        if($this->record !== null && $this->seccion != 'media')
            $this->insert_db($info);
        
        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo $json;
    }
    
    public function delete() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        $file_path = $this->options['upload_dir'].$file_name;
        //$file_dir = $this->options['upload_url'].$file_name;
        $file_dir = $this->options['upload_url'].rawurlencode($file_name);
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'].$file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
            if($this->record !== null && $this->seccion != 'media')
                $this->delete_db($file_dir);
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }
    
    function insert_db($info){
        include_once '../config/connection.php';
        $i = 1;
        foreach($info as $index){
            $query = "INSERT INTO images SET url = '".$index->url."', orden = 1000, enabled = 1, parent_id = ".$this->record.", section = '".$this->seccion."', title='".$index->name."'";
            mysql_query($query, $link);
            $i++;
        }
    }
    
    function delete_db($info){
        include_once '../config/connection.php';
        $query = "DELETE FROM images WHERE url = '".$info."' AND parent_id = ".$this->record;
        mysql_query($query, $link);
    }
}

//Check if there is a section
if(isset ($_REQUEST['seccion'])){
    //If so, init the vars for the options with the correct directories
    $seccion = $_REQUEST['seccion'];
    $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/img/cms/'.$seccion;
    $flag = 0;
    
    //Will be images in a record?
    if(isset ($_REQUEST['insert_id'])){
        //Overwrite the vars with new values
        $dir = $_REQUEST['insert_id'];
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/img/cms/'.$seccion."/".$dir;
        $flag = 1;
    }
    
    if(!is_dir($upload_dir))
        mkdir ($upload_dir, 0777);
        
    
    $options = array(
        'upload_dir'     => (is_dir($upload_dir.'/files/')) ? $upload_dir.'/files/' : createDir($upload_dir.'/files/'),
        'upload_url'     => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/files/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/files/',
        'image_versions' => array(
            'thumbnail'  => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/')) ? $upload_dir.'/thumbnails/' : createDir($upload_dir.'/thumbnails/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/'
            ),
        )
    );
    //If there are other sections that need thumbnails whit its own sizes put it in an if
    //For example
    if($seccion == 'blog'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 50,
                'max_height'     => 50,
                'width'          => 50,
                'height'         => 50,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 250,
                'max_height'     => 250,
                'width'      => 250,
                'height'     => 250,
            ),
            'thumb_preview' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_preview/')) ? $upload_dir.'/thumbnails/thumb_preview/' : createDir($upload_dir.'/thumbnails/thumb_preview/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_preview/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_preview/',
                'max_width'      => 321,
                'max_height'     => 135,
                'width'      => 321,
                'height'     => 135,
            ),
            'thumb_post' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_post/')) ? $upload_dir.'/thumbnails/thumb_post/' : createDir($upload_dir.'/thumbnails/thumb_post/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_post/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_post/',
                'max_width'      => 681,
                'max_height'     => 196,
                'width'      => 681,
                'height'     => 196,
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;
    } else if($seccion == 'events'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 160,
                'max_height'     => 209,
                'width'          => 160,
                'height'         => 209,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 317,
                'max_height'     => 30000,
                'width'      => 317,
                'height'     => 30000,
                'crop_image' => false                
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;        

    } else if($seccion == 'places'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 138,
                'max_height'     => 98,
                'width'          => 138,
                'height'         => 98,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 317,
                'max_height'     => 30000,
                'width'      => 317,
                'height'     => 30000,
                'crop_image' => false                              
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;
       } else if($seccion == 'places_types'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 50,
                'max_height'     => 50,
                'width'          => 50,
                'height'         => 50,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 319,
                'max_height'     => 171,
                'width'      => 319,
                'height'     => 171,                  
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;         
    
        } else if($seccion == 'nightclubs'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 50,
                'max_height'     => 50,
                'width'          => 50,
                'height'         => 50,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 319,
                'max_height'     => 171,
                'width'      => 319,
                'height'     => 171,                  
            ),
            'thumb_all' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_all/')) ? $upload_dir.'/thumbnails/thumb_all/' : createDir($upload_dir.'/thumbnails/thumb_all/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_all/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_all/',
                'max_width'      => 314,
                'max_height'     => 89,
                'width'      => 314,
                'height'     => 89,                  
            ),
            'thumb_single' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_single/')) ? $upload_dir.'/thumbnails/thumb_single/' : createDir($upload_dir.'/thumbnails/thumb_single/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_single/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_single/',
                'max_width'      => 680,
                'max_height'     => 94,
                'width'      => 680,
                'height'     => 94,                  
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;         
                
        } else if($seccion == 'galleries'){
        $image_versions = array(
            'thumb_small' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_small/')) ? $upload_dir.'/thumbnails/thumb_small/' : createDir($upload_dir.'/thumbnails/thumb_small/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_small/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_small/',
                'max_width'      => 50,
                'max_height'     => 50,
                'width'          => 50,
                'height'         => 50,
            ),
            'thumb_big' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_big/')) ? $upload_dir.'/thumbnails/thumb_big/' : createDir($upload_dir.'/thumbnails/thumb_big/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_big/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_big/',
                'max_width'      => 250,
                'max_height'     => 250,
                'width'      => 250,
                'height'     => 250,                
            ),
            'thumb_album' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_album/')) ? $upload_dir.'/thumbnails/thumb_album/' : createDir($upload_dir.'/thumbnails/thumb_album/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_album/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_album/',
                'max_width'      => 150,
                'max_height'     => 110,
                'width'      => 150,
                'height'     => 110,                
            ),
            'thumb_gallery' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_gallery/')) ? $upload_dir.'/thumbnails/thumb_gallery/' : createDir($upload_dir.'/thumbnails/thumb_gallery/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_gallery/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_gallery/',
                'max_width'      => 640,
                'max_height'     => 100000,
                'width'      => 640,
                'height'     => 100000,  
                'crop_image' => false,
            ),
            'thumb_banner' => array(
                'upload_dir' => (is_dir($upload_dir.'/thumbnails/thumb_banner/')) ? $upload_dir.'/thumbnails/thumb_banner/' : createDir($upload_dir.'/thumbnails/thumb_banner/'),
                'upload_url' => ($flag == 0) ? getFullUrl().'/img/cms/'.$seccion.'/thumbnails/thumb_banner/' : getFullUrl().'/img/cms/'.$seccion.'/'.$dir.'/thumbnails/thumb_banner/',
                'max_width'      => 487,
                'max_height'     => 190,
                'width'      => 487,
                'height'     => 190                
            )
        );
        $image_versions = array_merge($options['image_versions'], $image_versions);
        $options['image_versions'] = $image_versions;                
    }else {
        $dir = null;
    }
    $upload_handler = new UploadHandler($options, $seccion, $dir);
}else{
    $upload_handler = new UploadHandler();
}

header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('Content-Disposition: inline; filename="archivos.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        $upload_handler->post();
        break;
    case 'DELETE':
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}

function getFullUrl() {
return
    (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
    (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
    (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
    (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
    $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT'])));
}

function createDir($dir){
    mkdir($dir, 0777);
    return $dir;
}