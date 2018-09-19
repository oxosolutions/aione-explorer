<?php
include_once "includes/functions.php";
include_once "vendor/php-image-resize/lib/ImageResize.php";
use \Gumlet\ImageResize;

$path = 'files';

scan_directory($path);

function scan_directory($path){
	$files = scan($path);

	echo "<pre>";
	print_r($files);
	echo "</pre>";

	generate_thumbnails($path);

}
function generate_thumbnails($path){
	resize_images($path);
}

function resize_images($path){
	$files = scan($path);
	foreach ($files as $key => $value) {

		if($value['type']=='file'){
			if (preg_match('/(\.jpg|\.png|\.bmp)$/i', $value['name'])) {
	 			  
				$dirName=create_thumb_directory($value['path']);

	 			$file=  pathinfo($value['name'], PATHINFO_FILENAME).'.'.strtolower(pathinfo($value['name'],PATHINFO_EXTENSION));

				$image = new ImageResize($value['path']);
				$image->resizeToBestFit(300, 300);
				$image->save($dirName.$file);
			} 
		}

		if($value['type']=='folder'){

			if(strtolower($value['name'])!='thumb')
			{
				//scanDir1($value['path']);	
			}
		}	   
	}
}

function create_thumb_directory($path){

	$basepath = dirname($path);
	
	if(!file_exists($basepath.'/thumb')){
		mkdir($basepath.'/thumb',0755,true);
	}

	return $basepath.'/thumb/';
}