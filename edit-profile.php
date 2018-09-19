<?php
$page_title="Edit Profile";
include('templates/html-start.php');
if (isset($_POST['action']) && $_POST['action'] == 'edit-profile') {
    $userDetails = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone']];
    $userInfo = [
            'email' => $_POST['email'],
            'username' => $_POST['username']];

    $user->updateDetails($userDetails);
    $user->updateInfo($userInfo);


    $message = 'updated successfully';
}

$userInfo = $user->getInfo();
$userDetails = $user->getDetails();
?>
<section class="edit-profile mb-20">
    <form action="edit-profile.php" method="post">
        <input type="hidden" name="action" value="edit-profile">
        <div class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field"><?php echo __('User ID'); ?></label>
            </div>
            <div class="field field-type-text">
                <input class="input-text_field" id="userkey" name="user_id" readonly type="text" value="<?php echo $userInfo['user_id']; ?>" >
            </div>
        </div>
        <!-- field -->
        <div  class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('Email')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="email" type="text" value="<?php echo $userInfo['email']; ?>">
            </div>
        </div>
        <!-- field -->
        <div  class="field-wrapper">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('Username')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="username" type="text" value="<?php echo $userInfo['username']; ?>">
            </div>
        </div>
        <!-- field -->
     
        <div class="field-wrapper ">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('First Name')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="first_name" type="text" value="<?php echo $userDetails['first_name']; ?>">
            </div>
        </div>
        <!-- field -->
        <div class="field-wrapper ">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('Last Name')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="last_name" type="text" value="<?php echo $userDetails['last_name']; ?>">
            </div>
        </div>
        <!-- field -->
        <div class="field-wrapper ">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('Address')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="address" type="text" value="<?php echo $userDetails['address']; ?>">
            </div>
        </div>
        <!-- field -->
        <div class="field-wrapper ">
            <div class="field-label">
                <label for="input_text_field">
                    <?php echo __('Phone')?>
                </label>
            </div>
            <!-- field label-->
            <div class="field field-type-text">
                <input class="input-text_field" id="input_text_field" name="phone" type="text" value="<?php echo $userDetails['phone']; ?>">
            </div>
        </div>
        <!-- field -->
                                                                    <!-- field -->
        <button class="aione-button fullwidth medium circle primary" type="submit" value="<?php echo __('Update');?>">Update</button>
    </form>
</section>



<!-- .aione-row -->
<?php include('templates/html-end.php'); ?>
                              
