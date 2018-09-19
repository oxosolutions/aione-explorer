 <?php 
$page_title="Dashboard";
$generate_thumbnails_class = "active";
include('templates/html-start.php'); 
?>
<section class="aione-section fullwidth">
  <div class="wrapper pt-20 mr-10">

<?php 
include_once "includes/functions.php";
include_once "vendor/php-image-resize/lib/ImageResize.php";
use \Gumlet\ImageResize;

$path = 'files';

scan_directory($path);

function scan_directory($path){
  $files = scan($path);
  /*
  echo "<pre>";
  print_r($files);
  echo "</pre>";
  */

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
          
        echo("<script>console.log('PHP: ".$value['path']."');</script>");
          
        $dirName=create_thumb_directory($value['path']);

        $file=  pathinfo($value['name'], PATHINFO_FILENAME).'.'.strtolower(pathinfo($value['name'],PATHINFO_EXTENSION));

        $image = new ImageResize($value['path']);
        $image->resizeToBestFit(300, 300);
        $image->save($dirName.$file);
      } 
    }

    if($value['type']=='folder'){
      if(strtolower($value['name'])!='thumb'){
        scan_directory($value['path']); 
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
?>

  
  </div>
</section>
<?php include('templates/html-end.php'); ?>