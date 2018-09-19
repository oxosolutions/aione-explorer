<?php
if(!file_exists(realpath(__DIR__) . DIRECTORY_SEPARATOR . "ASConfig.php")) {
     header("Location: install/install.php");
}

include 'ASConfig.php';
include 'ASSession.php';
include 'ASDatabase.php';
include 'ASEmail.php';
include 'ASLogin.php';
include 'ASRegister.php';
include 'ASUser.php';
include 'ASComment.php';

$db = new ASDatabase(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

ASSession::startSession();

$login    = new ASLogin();
$register = new ASRegister();
$mailer   = new ASEmail();
