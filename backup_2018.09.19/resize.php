<?php
include_once "includes/functions.php";
include_once "vendor/php-image-resize/lib/ImageResize.php";
use \Gumlet\ImageResize;


//Passing the By Default directory Name('files')

$files = scan('files'); //Scaning the directory


//Printing the Files on to the screen

echo "<pre>";
print_r($files);
echo "</pre>";


generate_thumbnails();//Function to Generate Thumbnails


function generate_thumbnails(){
	resize_images(); //Creating the Thumbnails
}

function resize_images(){
	//$files = scan('files');
	 global $files;
	foreach ($files as $key => $value) {
		if($value['type']=='file'){
			if (preg_match('/(\.jpg|\.png|\.bmp)$/i', $value['name'])) {
	 			  
				$dirName=create_thumb_directory($value['path']);//Creating and getting the Directory Name

				//Creating the file Name 	
	 			$file=  pathinfo($value['name'], PATHINFO_FILENAME).'.'.strtolower(pathinfo($value['name'],PATHINFO_EXTENSION));

				$image = new ImageResize($value['path']);
				$image->resizeToBestFit(300, 300);
				$image->save($dirName.$file);//Generating the Thumbfile
			} 
		}

		if($value['type']=='folder'){

			if(strtolower($value['name'])!='thumb')
			{
				
			}
			


		}	   
			
	}
}

//Checking the thumb folder exists in the current directory or not, 
//if not than Create that thumb folder
function create_thumb_directory($dir){

	$path=dirname($dir);
	$directoryName=basename($path);
	
		if(!file_exists($path.'/thumb')){
			mkdir($path.'/thumb',0777,true);
		}

		return $path.'/thumb/';
}



