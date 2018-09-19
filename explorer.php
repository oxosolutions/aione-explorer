 <?php 
$page_title="Dashboard";
$dashboard_class = "active";
include('templates/html-start.php'); 
?>
<section class="aione-section">
<div class="wrapper pt-20 mr-10 bg-blue-grey bg-lighten-5">

  <!-- Popup -->
    <div class="img_add" style="display:none;">
    <a class="cross">X</a>
    <img src='' alt='' class='zooming'/>
    <div class="linkcopy">Copy File Link <input type="text" class="modlink" value=""/></div>
  </div>
  <!-- Popup -->
    
  <div class="filemanager">

    <div class="search">
      <input type="search" placeholder="Find a file.." />
    </div>

    <div class="breadcrumbs"></div>
    <div class="views">
      
    </div>
    
    <ul class="data"></ul>

    <div class="nothingfound">
      <div class="nofiles"></div>
      <span>No files here.</span>
    </div>

  </div>



  <!-- Include our script files -->


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="assets/js/script.js"></script>
<script>
$('body').on('click','.modfilepng, .modfilejpg, .modfilejpeg, .modfilegif',function(e){
   e.preventDefault();
   var url = window.location.href;
     var jj = $(this).attr('href');
   var url = url.split("#");
   var url = url[0];
   
   var imglink = url+jj;
    //imglink = imglink.replace(/#files/g,'')
    //imglink = imglink.replace(/%2F/g,'')
   $(".img_add").show();
   $(".img_add").center();
   $('.modlink').val(imglink);
   $('img.zooming').attr('src', imglink);
});

$('body').on('click','.cross',function(e){
   e.preventDefault();
   $(".img_add").hide();
});

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, ($(document).height() - $(this).height()) / 2));
    this.css("left", Math.max(0, ($(document).width() - $(this).width()) / 2));
    return this;
}

</script>
  
</div>
</section>
<?php include('templates/html-end.php'); ?>