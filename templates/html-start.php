<?php

error_reporting(E_ALL);
include 'ASEngine/AS.php';
include("includes/Language.php");
include("includes/functions.php");
include("includes/auth.php");

?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <?php 
      include('templates/head.php'); 
   ?>
   </head>
   <body>
      <div id="aione_wrapper" class="aione-wrapper layout-header-top aione-layout-wide aione-theme-acrane">
         <div class="wrapper">
            <?php 
            if(@$page != 'login'){
               include('templates/header.php'); 
            }
            ?>
            <div id="aione_main" class="aione-main p-0">
               <div class="wrapper">
                  <?php 
                  if(@$page != 'login'){ 
                     include('templates/sidebar.php');
                  }
                  ?>
                  <div id="aione_content" class="aione-content">
                     <div class="wrapper">
                     
                        <div id="aione_page_header" class="aione-page-header">
                           <div class="wrapper">
                              <div>
                                 <h4 class="aione-page-title"><?php echo __($page_title)?></h4>
                              </div>
                              <div class="clear"></div>
                           </div>
                           <!-- .wrapper -->
                        </div>
                        <!-- .aione-page-header -->
                        <div id="aione_page_content" class="aione-page-content ">
                           <div class="wrapper">