<?php
include_once "includes/functions.php";
include_once "vendor/php-image-resize/lib/ImageResize.php";
use \Gumlet\ImageResize;

$files = scan('files');

echo "<pre>";
print_r($files);
echo "</pre>";


$image = new ImageResize('files/images/IMG_8172.JPG');
$image->resizeToBestFit(300, 300);
$image->save('files/images/IMG_8172_thumb.jpg');

foreach ($variable as $key => $value) {
    # code...
}
