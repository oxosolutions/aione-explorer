<?php 
$page_title="Login ";
$page = "login";

include('templates/html-start.php'); 
?>
<style type="text/css">
.aione-page-header{
   display: none;
}
.aione-wrapper{
   .background-color: #f8f8f8;
}
.aione-content{
	width: 100%;
}
.aione-page-content{
	min-width: 480px;
	max-width: 480px;
	margin: 60px auto;
}
</style>
<section class="login aione-shadow">
   <div class="bg-white box-shadow" >
      <div class="pv-20 ph-30 aione-align-center">
         <div class="font-size-28 mb-20 mt-20">
            OXO Admin | OXO Solutions®
         </div>
         <div class="center-align mb-20">
            <span class="font-weight-100 blue-grey darken-2">LOG IN TO YOUR</span>
            <span class="font-weight-800  blue-grey darken-4">ACCOUNT</span>
         </div>
         <form id="loginForm" onsubmit="return false">
            <div class="mb-20">
               <input type="text" class="text-input required aione-border font-size-17 aione-rounded p-12 width-100 mb-2" value="" placeholder="Username" id="login-username" name="username">
            </div>
            <div class="mb-20">
               <input type="password" class="text-input required text-input required aione-border font-size-17 aione-rounded p-12 width-100 mb-2" value="" placeholder="Password" id="login-password" name="password">
            </div>

            <div class="mb-20">
               <input type="submit" id="btn-login" class="bg-teal  white pv-10 ph-40 font-size-18 font-weight-400" value="Login">
            </div>
         </form>
      </div>
   </div>
</section>
<?php include('templates/html-end.php'); ?>
<script type="text/javascript" src="assets/js/sha512.js"></script>
<script type="text/javascript" src="assets/scripts/asengine.js"></script>
<script type="text/javascript" src="assets/scripts/login.js"></script>