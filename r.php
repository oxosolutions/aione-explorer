<?php
$path = realpath('files');

$di = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach($di as $name => $fio) {
    $newname = $fio->getPath() . DIRECTORY_SEPARATOR . strtolower( $fio->getFilename() );
    echo $newname, "\r\n";
    //rename($name, $newname); - first check the output, then remove the comment...
}