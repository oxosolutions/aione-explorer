<?php
$page_title="Change password";
include('templates/html-start.php');
if (isset($_POST['action']) && $_POST['action'] == 'change-password') {
    
    $validate = $user->validatePassword($_POST['new_pass'],$_POST['conf_pass']);
    if ($validate) {
        $password_updated = $user->updatePassword($_POST['password'],$_POST['new_pass']);
        if ($password_updated) {
            $message_success = "change successfully";
        }else{
            $message_error = "wrong old password";
        }
    }else{
        $message_error = "New password and confirm password do not match";
    }   
   
}
?>
<section class="edit-profile mb-20">
    <?php if (!empty($message_success)) { ?>
        <div class="aione-message success">
            <?php echo $message_success; ?>
        </div>
    <?php } ?> 
    <?php if (!empty($message_error)) { ?>
        <div class="aione-message warning">
            <?php echo $message_error; ?>
        </div>
    <?php } ?>    
    <form action="" method="post">
        <input type="hidden" name="action" value="change-password">
        <input type="hidden" name="password" value="" id="old_password">
        <input type="hidden" name="new_pass" value="" id="new_password">
        <input type="hidden" name="conf_pass" value="" id="password_confirmation">
        <div class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field1"><?php echo __('Current password'); ?></label>
            </div>
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field1" name="old_password" type="password" >
            </div>
        </div>
        <!-- field -->
        <div class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field2">
                    <?php echo __('New Password')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field2" name="new_password" type="password">
            </div>
        </div>
        <!-- field -->
        <div  class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field3">
                    <?php echo __('Confirm Password')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field3" name="password_confirmation" type="password" >
            </div>
        </div>
        <!-- field -->
                      <!-- field -->
        <button class="aione-button fullwidth medium circle primary" type="submit" >Change Password</button>
    </form>
</section>
<script type="text/javascript" src="assets/js/sha512.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('keyup','input[type=password]',function(){
            var password = $(this).val();
            password = CryptoJS.SHA512(password).toString();
            var target_id = $(this).attr('name');
            $("#"+target_id).val(password);
        })
    })
</script>



<!-- .aione-row -->
<?php include('templates/html-end.php'); ?>
                              
