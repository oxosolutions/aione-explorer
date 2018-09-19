<?php
$page_title="Manage Users";
$manage_users_class = "active";
$auth_level = 1;
include('templates/html-start.php');

if ( isset($_POST['action']) && $_POST['action'] == 'save-user' ) {
    $obj1 = new ASRegister();
    $pass = $obj1->hashPassword($_POST['encrypt_password']);
    $user_inserted = $db->insert('as_users', array(
         "username"  => $_POST['username'],
         "email"  => $_POST['email'],
         "confirmed"  => $_POST['confirmed'],
         "password"  => $pass,
         "user_role"  => $_POST['role']
    ));
}

if ( isset($_POST['action']) && $_POST['action'] == 'update-user' ) {
    $obj2 = new ASRegister();
    $pass = $obj2->hashPassword($_POST['encrypt_password']);
    $user_updated = $db->update('as_users', array(
        "username"  => $_POST['username'],
        "email"  => $_POST['email'],
        "confirmed"  => $_POST['confirmed'],
        "password"  => $pass,
        "user_role"  => $_POST['role']),
        "user_id= :id",
        array( "id" => $_POST['user_id'] )
    );
    $message = "User updated successfully";
    // header('location:manage-users.php');
}

if( isset($_GET['action']) && $_GET['action'] == 'edituser' ){
    $single_user = $db->select("SELECT * FROM as_users WHERE user_id = ".$_GET['user_id']);
	$single_user = $single_user[0];
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $Query = $db->select('DELETE FROM as_users WHERE user_id = '.$_GET['user_id']);
    $message = "User Deleted successfully";
}

$data = array();
$headers = array('ID','Username','Email','Active','Register Date','Last Login','Actions');
$users = $db->select("SELECT * FROM `as_users`");
foreach ($users as $key => $user):
    $tmpUser = new ASUser($user['user_id']);
    $userRole = $tmpUser->getRole();
    $data[$key][] =  $user['user_id'];
    $data[$key][] =  $user['username'];
    $data[$key][] =  $user['email'];
    $data[$key][] =  $user['confirmed'] == "Y"?"<p class='green'>Yes</p>":"<p class='red'>No</p>";
    $data[$key][] =  $user['register_date'];
    $data[$key][] =  $user['last_login'];
    $data[$key][] =  '
    <a class="action-button square aione-tooltip" title="Edit user" href="?user_id='.$user['user_id'].'&action=edituser"><i class="ion-md-create"></i></a>
    <a href="?user_id='.$user['user_id'].'&action=delete"" class="action-button square aione-tooltip" title="Delete user" onclick="return confirm(\'Are you sure?\');"><i class="ion-md-trash bg-red"></i></a>';
endforeach;

?>

<section class="add-new-button">
    <a id="add_site" class="aione-button small circle wide primary" href="?action=adduser">Add user</a>
</section>
<?php if (!empty(@$message)) { ?>
    <div class="aione-message success">
        <?php echo @$message; ?>
    </div>    
<?php } ?>

<?php if ( ( isset($_GET['action']) && $_GET['action'] == 'adduser' ) || ( isset($_GET['action']) && $_GET['action'] == 'edituser' ) ): ?>
    <div class="aione-border p-10 mb-15">
        <form method="post">
            <?php if ($_GET['action'] == 'adduser') { ?>
                <input type="hidden" name="action" value="save-user">
            <?php }elseif ($_GET['action'] == 'edituser'){ ?>
                <input type="hidden" name="action" value="update-user">
                <input type="hidden" name="user_id" value="<?php echo @$single_user['user_id']; ?>">
                
            <?php } ?>
            <input type="hidden" name="encrypt_password" value="" id="password">
            <div class="field-wrapper">
                <div class="field-label">
                    <label for="site_id"><h4 class="field-title">
                        <?php echo __('Username')?></h4></label>
                </div>
                <div class="field field-type-select">
                    <input type="text" name="username" value="<?php echo @$single_user['username']; ?>">
                </div>
            </div> 
            <div class="field-wrapper">
                <div class="field-label">
                    <label for="site_id"><h4 class="field-title">
                        <?php echo __('Email')?></h4></label>
                </div>
                <div class="field field-type-select">
                    <input type="email" name="email" value="<?php echo @$single_user['email']; ?>">
                </div>
            </div> 
            <div class="field-wrapper">
                <div class="field-label">
                    <label for="site_id"><h4 class="field-title">
                        <?php echo __('Password')?></h4></label>
                </div>
                <div class="field field-type-select">
                    <input type="password" name="password" value="<?php echo "**********" ?>"  >
                </div>
            </div> 
            <div class="field-wrapper">
                <div class="field-label">
                    <label for="site_id"><h4 class="field-title">
                        
                        <?php echo __('Role')?></h4>
                    </label>
                </div>
                <div class="field field-type-select">
                    <select name="role">
                        <?php 
                            $roles = $db->select("SELECT * FROM `as_user_roles`");
                            foreach ($roles as $key => $value) : 
                        ?>
                            <option <?php echo ($value['role_id'] == @$single_user['user_role'])?'selected="selected"':''; ?> value="<?php echo $value['role_id']; ?>"><?php echo $value['role']; ?></option>    
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
            <div class="field-wrapper">
                <div class="field-label">
                    <label for="site_id"><h4 class="field-title">
                        <?php echo __('Confirmed')?></h4></label>
                </div>
                <div class="field field-type-select">
                    <input id="confirmedyes" type="radio" name="confirmed" value="Y" <?php if(@$single_user['confirmed'] == 'Y'){echo 'checked="checked"'; } ?>>
                    <label for="confirmedyes" class="display-inline-block mb-15">Yes</label><br>
                    <input id="confirmedno" type="radio" name="confirmed" value="N" <?php if(@$single_user['confirmed'] == 'N'){echo 'checked="checked"'; } ?>>
                    <label for="confirmedno">No</label><br>
                </div>
            </div> 
            <input type="submit" class="aione-button circle wide primary"  value="<?php echo __('Save User');?>">
        </form>
            
    </div>
        
<? endif; ?> 
<section class="ns">
    <?php echo aione_data_table($headers, $data, $id='users-',$class = 'compact');  ?>
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

<?php include('templates/html-end.php'); ?>
