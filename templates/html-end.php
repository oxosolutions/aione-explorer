                           </div>
                        </div>
                     </div>
                     <!-- .wrapper -->
                  </div>
                  <!-- .aione-content -->
               </div>
               <!-- .wrapper -->
            </div>
            <?php include('templates/footer.php'); ?>
            <?php include('templates/copyright.php'); ?>
         </div>
      </div>
     
      <script type="text/javascript">
         $(document).ready(function(){
            $( ".aione-header .aione-menu .aione-nav-item" ).click(function(e) {
               $(this).addClass("active").siblings().removeClass('active');
               console.log($(this).text());
            });

            $('body').on('click','.aione-profile > a',function(){
               $(this).parent().toggleClass('active');
            });
            $('body').click(function(){
                $('.users_div').slideUp(300);
            });
            $('.login_id').click(function(e){
                e.stopPropagation();
                $('.users_div').slideUp(300);
                var dataClass = $(this).data('toggle');
                $(this).parents('.users').find('.'+dataClass).slideToggle(300);
            });

         })
      </script>

   </body>
</html>