<?php 
$ln = @$_GET['ln'];
if(isset($ln)) { 
   ASSession::set('language',$ln);
}

@Language::Set(ASSession::get('language'));
Language::SetAuto(true);

if(@$page == 'login'){
	if($login->isLoggedIn()){
	   header("Location: index.php");
	}
} else {
	if(!$login->isLoggedIn()){
	   header("Location: login.php");
	} else {
		$user = new ASUser(ASSession::get("user_id"));
		$userInfo = $user->getInfo();
		$userDetails = $user->getDetails();
		$user_role = $userInfo['user_role'];
		
		if(!empty(@$auth_level)){
			if(@$auth_level < $user_role){
				header("Location: access-denied.php");
			}
		}
	}
}