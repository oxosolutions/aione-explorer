<div id="aione_header" class="aione-header">
    <div class="wrapper">
        <div class="logo aione-float-left bg-white pv-4">
            <a href="index.php" title="OXO Solutions® Logo | OXO Solutions® is Registered TradeMark of OXO IT SOLUTIONS PRIVATE LIMITED" class="">
                <img src="assets/images/oxosolutions-logo.svg" class="aione-float-left" alt="OXO Solutions® Logo" width="60">
            </a>
        </div>
        <div class="nav">
            <nav id="aione_nav_header" class="aione-nav horizontal">
                <ul id="aione_menu_header" class="aione-menu">
                    <li class="aione-nav-item level0 <?php echo @$explorer_class; ?>">
                        <a href="explorer.php" title="File Explorer">
                            <span class="nav-item-icon"><i class="ion-ios-document"></i></span>
                            <span class="nav-item-text">File Explorer</span>
                            <span class="nav-item-desc">Files</span>
                        </a>
                    </li>
                    <?php if($user->isAdmin()): ?>
                      <li class="aione-nav-item level0 <?php echo $generate_thumbnails_class; ?>">
                        <a href="generate-thumbnails.php">
                           <span class="nav-item-icon"><i class="ion-ios-shuffle"></i></span>
                           <span class="nav-item-text">Generete Thumbnail</span>
                           <span class="nav-item-desc">Thumb</span>
                        </a>            
                     </li>
                      <li class="aione-nav-item level0  <?php echo @$manage_users_class; ?>">
                          <a href="manage-users.php" title="Manage users ">
                              <span class="nav-item-icon"><i class="ion-ios-person"></i></span>
                              <span class="nav-item-text">Manage Users</span>
                              <span class="nav-item-desc">Users</span>
                          </a>
                      </li>
                      <li class="aione-nav-item level0  <?php echo @$manage_user_roles_class; ?>">
                          <a href="manage-user-role.php" title="Manage roles">
                              <span class="nav-item-icon"><i class="ion-ios-people"></i></span>
                              <span class="nav-item-text">Manage User Roles</span>
                              <span class="nav-item-desc">Roles</span>
                          </a>
                      </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="aione-header-right p-13">
            <div class="aione-header-item aione-profile">
                <a href="#"><img class="user-avatar"  role="none" src="assets/images/user.png"></a>
                <div class="aione-header-widget aione-profile-widget">
                    <div class="aione-row">
                        <div class="aione-widget-header">
                            <h3 class="aione-widget-title">
                            Welcome 
                        </h3>
                        </div>
                        <!-- .aione-widget-header -->
                        <div class="aione-widget-content">
                            <ul class="profile-menu">
                                <li><a href="view-profile.php" class="">View Profile</a></li>
                                <li><a href="edit-profile.php" class="">Edit Profile</a></li>
                                <li><a href="change-password.php" class="">Change Password</a></li>
                            </ul>
                        </div>
                        <!-- .aione-widget-content -->
                        <div class="aione-widget-footer">
                            <div class="aione-widget-footer-left">

                            </div>
                            <!-- .aione-widget-footer-left -->
                            <div class="aione-widget-footer-right">
                                <a id="logout" class="aione-button small circle primary dark logout-button" href="logout.php"><span class="white">Logout</span></a>
                            </div>
                            <!-- .aione-widget-footer-right -->
                        </div>
                        <!-- .aione-widget-footer -->

                    </div>
                    <!-- .aione-row -->
                </div>
                <!-- .aione-header-widget -->

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>