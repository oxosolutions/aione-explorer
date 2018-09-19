 <?php 
$page_title="Dashboard";
$dashboard_class = "active";
include('templates/html-start.php'); 
?>
<style type="text/css">
   .dashboard-button-widget{
      padding: 15px 30px;
      margin-right: 1.4%;
      margin-bottom: 20px;
      width: 13.75%;
      color:#ffffff;
      float:left;
      display:block;
      text-align: center;
      background-color: #546e7a;
      -webkit-transition: all 180ms ease-in-out;
      -moz-transition: all 180ms ease-in-out;
      transition: all 180ms ease-in-out;
   }
   .dashboard-button-widget:hover{
      color:#ffffff;
      background-color: #1b2a31;
      
   }
   .dashboard-button-widget > i{
      text-align: center;
      display: block;
      font-size: 30px;
      margin-bottom: 10px;
   }
</style>
<section class="dashboard pt-20 mr-10">

  <div class="ar aione-border pl-20 pt-20 mb-20">
    <a href="explorer.php" class="dashboard-button-widget">
      <i class="ion-md-lock"></i>
      File Explorer
    </a>
  </div>
   
  <?php if($user->isAdmin()): ?>
    <div class="ar aione-border pl-20 pt-20 mb-20">
      <a href="generate-thumbnails.php" class="dashboard-button-widget">
        <i class="ion-ios-person"></i>
       Generete Thumbnail
      </a>
      <a href="manage-users.php" class="dashboard-button-widget">
        <i class="ion-ios-person"></i>
        Manage Users
      </a>
      <a href="manage-user-role.php" class="dashboard-button-widget">
        <i class="ion-ios-people"></i>
        Manage User Role
      </a>
    </div>
  <?php endif;?>

</section>
<?php include('templates/html-end.php'); ?>