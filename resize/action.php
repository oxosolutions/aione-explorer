<?php
    include_once 'ActionClass.php';

    $request = array_merge($_REQUEST,$_FILES);
    $compressedImages = [];
    if(isset($request['selectedImages'])){
        $compressedImages = $ActionClass->imageCompress($request);
    }

    if(isset($request['source_path'])){
        $result = $ActionClass->compressByDirectory($request);
        if($result['status'] == 'error'){
            $error_message = $result['message'];
        }else{
            $message = 'Images compressed successfully!';
        }
    }
?>