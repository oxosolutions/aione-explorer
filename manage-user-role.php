
<?php 
$page_title="Manage User Roles";
$manage_user_roles_class = "active";
$auth_level = 1;
include('templates/html-start.php'); 
$data = array();
$headers = array('Role Name','Users With This Role','Role Type','Actions',);
$roles = $db->select("SELECT * FROM `as_user_roles` ");
foreach ($roles as $key => $role):
    $result = $db->select("SELECT COUNT(*) AS num FROM `as_users` WHERE `user_role` = :r", array( "r" => $role['role_id']));
    $usersWithThisRole = $result[0]['num'];
    $data[$key][] =  $role['role'];
    $data[$key][] =  $usersWithThisRole;
    $data[$key][] =  ($role['role_id']>3)?"Custom":"System"; 
    $data[$key][] =  ($role['role_id']>3)?'
    <a class="action-button square aione-tooltip" title="Edit user role" href="?edit='.$role['role_id'].'"><i class="ion-edit "></i></a>
    <a class="action-button square aione-tooltip" title="Delete user role" href="?delete='.$role['role_id'].'" onclick="return confirm(\'Are you sure?\');"><i class="ion-android-delete bg-red"></i></a>':'';
   
endforeach;
if(isset($_REQUEST['save_role'])){
    if(isset($_REQUEST['edit'])){
        $Query = $db->update('as_user_roles',[
                'role' => $_REQUEST['role'],
                'role_id= :id'],
                ['id' => $_REQUEST['edit']]
        );
        $message = 'Domain updated successfully';
        header('location:manage-user-role.php');
    }else{
        $Query = $db->insert('as_user_roles',[
            'role' => $_REQUEST['role'],
        ]);
    }
    $message = 'Domain added successfully';
}
if(isset($_REQUEST['delete'])){
    $Query = $db->select('DELETE FROM as_user_roles WHERE role_id = '.$_REQUEST['delete']);
    header('location:manage-user-role.php');
}
$editData = [];
if(isset($_REQUEST['edit'])){
    $editData = $db->select('SELECT * FROM as_user_roles WHERE role_id = '.$_REQUEST['edit']);
}      


?>
<section class="add-new-button">
    <a id="add_site" class="aione-button small circle wide primary" href="?action=add_user_role">Add user role</a>
</section>

<?php
if(isset($_REQUEST['edit']) || @$_REQUEST['action'] == "add_user_role"): 
?>
<section class="form-section mb-20">
    <form action="" method="POST">
        <div class="aione-border mb-15">
            <div class="p-10 ar">
                <div id="User-key" class="field-wrapper">
                    <div class="field-label">
                        <label for="role-name">
                            <h4 class="field-title">Add Custom User Role</h4>
                        </label>
                    </div>
                    <!-- field label-->
                    <div class="field field-type-text">
                        <input class="input-text_field" id='role-name' placeholder="Role Name" placeholder="" data-validation="" name="role" type="text" value="<?=@$editData[0]['role']?>">
                    </div>
                </div>
                
                <button class="aione-button circle wide primary" name="save_role">Save
                        Role</button>
                <div class="clear"></div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php
endif;
?>
<section class="manage-user-role mb-20">
    <?php echo aione_data_table($headers, $data, $id='users-',$class = 'compact');  ?>
</section>
<?php include('templates/html-end.php'); ?>
