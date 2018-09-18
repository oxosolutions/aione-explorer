<?php
    include_once "action.php";
    // dd($ActionClass::testingMethod());
?>
<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" type="text/css" href="https://cdn.aioneframework.com/assets/css/aione.min.css">
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:100,300,400,600,700,800,900">
      <link rel="stylesheet" type="text/css" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/cropper.css">

      
      <title>Smaart Framework</title>
      <style type="text/css">
         ul{
            margin: 0 auto;
         }
         .wave
         {
         background: url(assets/images/banner_wave.svg) no-repeat top center;
         pointer-events: none;
         height: 200px; 
         background-size: cover;
         position: absolute;
         bottom: -2px;
         width: 100%;
         }
         .border-radius
         {
         border-radius: 5px;
         }
         .bg-img
         {
         background: url(assets/images/logo-bg.jpg) bottom center no-repeat;
         background-size: 100%;
         }
         .owl-nav
         {
         display: none;
         }
         .owl-dots
         {
         display: none;
         }
         .icon
         {
         background: url(assets/images/quote-icon.svg) 0 0 no-repeat;
         content: "";
         width: 39px;
         height: 25px;
         position: absolute;
         background-size: 39px 25px;
         }
         .icon-2
         {
         background: url(assets/images/quote-icon.svg) 0 0 no-repeat;
         content: "";
         width: 39px;
         height: 25px;
         position: absolute;
         background-size: 39px 25px;
         transform: rotate(180deg);
         }
         .owl-carousel .owl-stage-outer
         {
         	border:1px solid #e8e8e8;
         }
      </style>
   </head>
   <body>
      <div id="aione_wrapper" class="aione-wrapper page-home layout-header-top aione-layout-wide aione-theme-arcane">
         <div class="wrapper">
            <div id="aione_header" class="aione-header light load-template">
               
            </div>
            <!--aione-header-->
            <div id="aione_main" class="aione-main fullwidth p-0">
               <div class="wrapper">
                  <div id="aione_content" class="aione-content">
                     <div class="wrapper">
                        <div id="aione_page_content" class="aione-page-content m-0">
                           <div class="wrapper">
                              

                              <!--Core AP-->
                              <section style="background-color: #F4F7F9;">
                                <div class="ar ph-8p">
                                    <div class="ac l100">
                                        <h2 class="font-weight-700 font-size-32 blue-grey darken-4">Tools</h2>
                                    </div>
                                </div>
                                <div class="ar ph-8p">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="ac l50">
                                            <h3 class="font-weight-700 font-size-20 blue-grey darken-4">Image Compressor</h3>
                                            <br/>
                                            <input type="file" name="selectedImages[]" multiple>
                                            <select name="image_quality" class="mt-20">
                                                <option value="">Select Image Quality</option>
                                                <?php
                                                    for($i = 5; $i <= 100; $i = $i+5):
                                                ?>
                                                        <option value="<?=$i?>"><?=$i?></option>
                                                <?php
                                                    endfor;
                                                ?>
                                            </select>
                                            <select name="image_size" class="mt-20">
                                                <option value="">Select Image Size</option>
                                                <?php
                                                    for($i = 1; $i <= 10; $i++):
                                                ?>
                                                    <option value="<?=$i*100?>x<?=$i*100?>"><?=$i*100?>x<?=$i*100?></option>
                                                <?php
                                                    endfor;
                                                ?>
                                            </select>
                                            <button class="button font-size-14 mt-20 aione-float-right">Compress</button>
                                        </div>
                                    </form>
                                    <div class="ac l50">
                                        <?php
                                            if(!empty($compressedImages)):
                                                foreach($compressedImages as $key => $images):
                                        ?>
                                            <img src="<?=$images?>" />
                                        <?php
                                                endforeach;
                                            endif;
                                        ?>
                                        <h3 class="font-weight-700 font-size-20 blue-grey darken-4">Image Cropper</h3>
                                        <input type="file" name="image_for_crop">
                                        <img src="http://via.placeholder.com/500x300?text=Select%20Image%20to%20Crop" class="cropper">
                                        <a href="javascript:;" class="aione-button bg-black white p-10 mt-20 downloadImage" style="border-radius: 3px;">Download Image</a>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="ac l50">
                                            <h3 class="font-weight-700 font-size-20 blue-grey darken-4">Compress Images Directory</h3>
                                            <br/>
                                            <div class="field">
                                                <input type="text" name="source_path" class="" />      
                                                <span class="grey display-inline-block mt-5">Example: /path/to/your/directory</span>                                          
                                            </div>
                                            <select name="image_quality" class="mt-20">
                                                <option value="">Select Image Quality</option>
                                                <?php
                                                    for($i = 5; $i <= 100; $i = $i+5):
                                                ?>
                                                        <option value="<?=$i?>"><?=$i?></option>
                                                <?php
                                                    endfor;
                                                ?>
                                            </select>
                                            <select name="image_size" class="mt-20">
                                                <option value="">Select Image Size</option>
                                                <?php
                                                    for($i = 1; $i <= 10; $i++):
                                                ?>
                                                    <option value="<?=$i*100?>x<?=$i*100?>"><?=$i*100?>x<?=$i*100?></option>
                                                <?php
                                                    endfor;
                                                ?>
                                            </select>
                                            <span class="display-inline-block mt-10 red"><?=@$error_message?></span>
                                            <span class="display-inline-block mt-10 green"><?=@$message?></span>
                                            <button class="button font-size-14 mt-20 aione-float-right">Compress</button>
                                        </div>
                                    </form>
                                </div>
                                 
                              </section>
                              <!--Company Details-->
                              
                           </div>
                           <!--wrapper-->
                        </div>
                        <!--aione-page-content-->
                     </div>
                     <!--wrapper-->
                  </div>
                  <!--aione_content-->
               </div>
               <!--wrapper-->
            </div>
            <!--aione-main-->
            <div id="aione_footer" class="aione-footer dark load-template">   
            </div><!-- .aione-footer -->
            <div id="aione_copyright" class="aione-copyright dark load-template">
            </div><!-- .aione-copyright -->  
         </div>
         <!--wrapper-->
      </div>
      <script type="text/javascript" src="https://cdn.aioneframework.com/assets/js/vendor.min.js"></script>
      <script type="text/javascript" src="https://cdn.aioneframework.com/assets/js/aione.min.js"></script>
      <script type="text/javascript" src="assets/js/cropper.js"></script>
      <script>
            

            $(function() {

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('.cropper').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $('input[name=image_for_crop]').change(function(){
                    readURL(this);
                    setTimeout(function(){
                        loadInCropper();
                    }, 1000)
                    
                });
                
                function loadInCropper(){
                    var $cropper = $(".cropper"),
                        $dataX1 = $("#dataX1"),
                        $dataY1 = $("#dataY1"),
                        $dataX2 = $("#dataX2"),
                        $dataY2 = $("#dataY2"),
                        $dataHeight = $("#dataHeight"),
                        $dataWidth = $("#dataWidth"),
                        cropper;

                    $cropper.cropper({
                        aspectRatio: 16 / 9,
                        preview: ".extra-preview",
                        done: function(data) {
                            $dataX1.val(data.x1);
                            $dataY1.val(data.y1);
                            $dataX2.val(data.x2);
                            $dataY2.val(data.y2);
                            $dataHeight.val(data.height);
                            $dataWidth.val(data.width);
                        }

                    });

                    $('.downloadImage').click(function(){
                        var imagem = $cropper.cropper('getCroppedCanvas', { width: 620, height: 520 }).toDataURL("image/png").replace("image/png", "application/octet-stream");
                        var link = document.createElement('a');
                        link.addEventListener('click', function () {
                            link.href = imagem;
                            link.download = "myimage.png";
                        },false);
                        $(".cropper").cropper("destroy");
                        link.click();
                    });

                    cropper = $cropper.data("cropper");
                }
            })
        </script>
   </body>
</html>