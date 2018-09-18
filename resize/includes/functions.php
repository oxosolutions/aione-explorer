<?php
/************************************************************
*   @function get_image
*   @description Returns user id of logged in user
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @return uid [integer]
************************************************************/
require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
Image::configure(array('driver' => 'gd'));
function get_image($path, $filename, $size = null, $html = false){
    
    $ds = directory_separator();
    $base_file_path = $path.$ds.$filename;
    
    if(!File::exists($base_file_path)){
        return false;
    }
    
    $filename_elements = explode(".",$filename);
    //First element of Array
    $output_filename = current($filename_elements);
    //Last element of Array
    $output_file_extension = end($filename_elements);
    
    $image_size = get_file_size($size);
    
    
    $file_path = $path.$ds.$output_filename.'_'.$image_size.'.'.$output_file_extension;
    
    if(!File::exists($file_path)){
        resize_image($image_size , $filename, $path); 
    }
    
    return $file_path;
    

}

 // function get_form_settings($formId){
 //     $model = 'use App\Model\\Organization\\';
 // }

/************************************************************
*   @function get_profile_picture
*   @description Returns user id of logged in user
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @perm uid       [integer    optional    default null]
*   @perm size      [string optional    default null]
*   @perm html      [true/false optional    default false]
*   @return filename [mixed][string/html]
************************************************************/

function get_profile_picture($uid = null, $size = null, $html = false){
    if($uid == null){
        $uid = get_user_id();
    }
    if($size == null){
        $size = 'avatar';
    }
    
    $meta_key = 'user_profile_picture';
    $user_profile_picture = get_user_meta($uid,$meta_key, true);
    $user_profile_picture_url = 'assets/images/user_'.get_file_size($size).'.png';
    if(!empty($user_profile_picture)){
        $profile_picture_path = upload_path('user_profile_picture');
        
        if(!File::exists($profile_picture_path.directory_separator().$user_profile_picture)){
            delete_user_meta('user_profile_picture', $uid);
        } else {
            $user_profile_picture_url = get_image($profile_picture_path, $user_profile_picture, $size, false);
        }
    } 

    if($html){
        return '<img src="'.asset($user_profile_picture_url).'" data-user-id="'.$uid.'" class="user-profile-picture user-profile-picture-'.$size.'" />';
    }else{
        return $user_profile_picture_url;
    }

}



/************************************************************
*   @function upload_path
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @perm path      [string optional    default null]
*   @return upload_path [string]
************************************************************/

function upload_path($path = null){ 

    $directory_separator = '/';
    
    //inialize upload_path variable as empty string
    $upload_path = '';
    
    //Get Organization ID
    $organization_id = get_organization_id();
    
    //Get path variable from environment file
    $upload_path .= env('USER_FILES_PATH');
    
    //Append Organization ID
    $upload_path .= '_'.$organization_id;
    
    //Append directory separator 
    $upload_path .= $directory_separator;
    
    if($path != null){
        //Append provided path
        $upload_path .= $path;
    }
    if(!file_exists($upload_path)){
        mkdir($upload_path,0777,true);
    }
    //Return path of user files directory
    return $upload_path;
}

/************************************************************
*   @function upload_base_path
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @return upload_base_path [string]
************************************************************/

function upload_base_path(){    

    $upload_base_path = upload_path();
    
    //Return base path of user files directory
    return $upload_base_path;
}



/************************************************************
*   @function get_file_size
*   @description Returns dimensions if file
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @perm name      [string required    default null]
*   @return size [string]
************************************************************/

function get_file_size($name = null){
    
    $size = '';
    if($name == 'avatar'){
        $size = '50x50';
    }
    if($name == 'thumbnail'){
        $size = '100x100';
    }
    if($name == 'small'){
        $size = '150x150';
    }
    if($name == 'medium'){
        $size = '300x300';
    }
    if($name == 'large'){
        $size = '500x500';
    }
    
    //Return Size
    return $size;
}


/************************************************************
*   @function generate_filename
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @perm length        [integer    optional    default 40]
*   @perm timestamp     [true/false optional    default true]
*   @return filename [string]
************************************************************/
function generate_filename($length = 30, $timestamp = true){    

    //Check if non integer value is provided for first argument
    if(!is_int($length)){
        $length = intval($length);
    }
    
    //inialize filename variable as empty string
    $filename = '';
    
    //prepend timestamp in filename
    if($timestamp){
        $datetime = date('Ymdhis');
        $microtime = substr(explode(".", explode(" ", microtime())[0])[1], 0, 6);
        $filename .= $datetime.$microtime;
    }
    
    //Check if filename length is achieved or exceeded
    if( strlen($filename) > $length){
        $filename = substr($filename, 0, $length);
    } else {
        $random_string_length = $length - strlen($filename);
        for($i = 0; $i < $random_string_length; $i++){
            $filename .= mt_rand(1,9);
        }
    }
    
    //Return generated filename
    return $filename;
}

/************************************************************
*   @function get_timestamp
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @return current_timestamp [string]
************************************************************/
function get_timestamp(){
    
    $current_timestamp = generate_filename(20,true);
    //Return generated filename
    return $current_timestamp;
}

/************************************************************
*   @function resize_image
*   @access public
*   @since  1.0.0.0
*   @author SGS Sandhu(sgssandhu.com)
*   @perm size      [string optional    default 'thumbnail']
*   @perm source_path       [string optional    default null]
*   @perm destination_path      [string optional    default null]
*   @perm rename        [true/false optional    default false]
*   @return filename [string]
************************************************************/

function resize_image($size = 'thumbnail', $filename, $source_path = null, $destination_path = null, $rename = false){  
    
    $directory_separator = '/';
    
    if(empty($filename)){
        return false;
    } else {
        $filename_elements = explode(".",$filename);
        //First element of Array
        $output_filename = current($filename_elements);
        //Last element of Array
        $output_file_extension = end($filename_elements);
    }
    
    //generate_filename
    if($rename){
        $output_filename = generate_filename();
    }
    
    if($source_path == null){
        $source_path = upload_base_path();
    }
    if($destination_path == null){
        $destination_path = $source_path;
    }
    
    $source_path = trim($source_path, "/");
    $destination_path = trim($destination_path, "/");
    
    
    $image_width = 50;
    $image_height = 50;
    
    if($size == 'thumbnail'){
        $image_width = 150;
        $image_height = 150;
    } elseif($size == 'small'){
        $image_width = 300;
        $image_height = 300;
    } else{
        $size_elements = explode("x",$size);
        $image_width = $size_elements[0];
        $image_height = $size_elements[1];
    }
    
    
    $output_complete_url = $destination_path.$directory_separator.$output_filename.'_'.$image_width.'x'.$image_height.'.'.$output_file_extension;
    
    
    /*if(!File::exists($source_path.$directory_separator.$filename)){
        return false;
    }*/
    
    if($output_file_extension == "jpg" || $output_file_extension == "jpeg" || $output_file_extension == "png" || $output_file_extension == "gif"){
       
        //$image = str_replace(' ', '%20',$source_path.$directory_separator.$filename);
        $img = Image::make($source_path.$directory_separator.$filename)->resize($image_width, $image_height);
        $img->save($output_complete_url);
    }

    //Return True 
    return true;
}


function recurciveloop($loop){
    foreach ($loop as $loop_key => $loop_value) {
        echo "<li>";
        echo $loop_value['name'];
        if($loop_value['type'] == 'folder'){
            echo "<ul>";
            echo recurciveloop($loop_value['items']);
            echo "</ul>";
        } 
        echo "</li>";
    }
}
function scan($dir) {
    $files = array();
    if(file_exists($dir)) {
        foreach(scandir($dir) as $f){
            if(!$f || $f[0] == '.') {
                continue; // Ignore hidden files
            }
            if(is_dir($dir . '/' . $f)){
                $files[] = array(
                    "name" => $f,
                    "type" => "folder",
                    "path" => $dir . '/' . $f,
                    "items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
                );
                $path = $dir . '/' . $f;
                createDir($path,'.tmb');
            } else {
                $files[] = array(
                    "name" => $f,
                    "type" => "file",
                    "path" => $dir . '/' . $f,
                    "size" => filesize($dir . '/' . $f) // Gets the size of this file
                );
                
                //resize_image($size = 'thumbnail', $f, $dir, $destination_path, $rename = false);
            }
        }
    }
    return $files;
}

function createDir($path,$name){
    $completePath = $path.'/'.$name;
    if (!file_exists($completePath)) {
        mkdir($completePath, 0777, true);
    }
}
/*function createDirLoop($data){
    foreach ($data as $data_key => $data_value){
        if($data_value['type'] == 'folder' && $data_value['name'] != 'vendor'){
            createDir($data_value['path'],'Thmb');
            createDirLoop($data_value['items']);
        }
    }
}*/