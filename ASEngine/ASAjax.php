<?php
include 'AS.php';

$action = $_POST['action'];

switch ($action) {
	case 'checkLogin':
		$logged = $login->userLogin($_POST['username'], $_POST['password']);
        if($logged === true)
            echo "true";
		break;
        
    case "registerUser":
        $register->register($_POST['user']);
        break;
        
    case "resetPassword":
        $register->resetPassword($_POST['newPass'], $_POST['key']);
        break;
        
    case "forgotPassword":
        $register->forgotPassword($_POST['email']);
        break;
        
    case "logout":
        ASSession::destroySession();
        break;
        
    case "postComment":
        $ASComment = new ASComment();
        echo $ASComment->insertComment(ASSession::get("user_id"), $_POST['comment']);
        break;
        
    case "updatePassword":
        $user = new ASUser(ASSession::get("user_id"));
        $user->updatePassword($_POST['oldpass'], $_POST['newpass']);
        break;
        
    case "updateDetails":
        $user = new ASUser(ASSession::get("user_id"));
        $user->updateDetails($_POST['details']);
        break;
        
    case "changeRole":
        $user = new ASUser($_POST['userId']);
        echo ucfirst($user->changeRole());
        break;
        
    case "deleteUser":
        $user = new ASUser($_POST['userId']);
        $user->deleteUser();
        break;
    
    case "getUserDetails":
        $user = new ASUser($_POST['userId']);
        $info = $user->getInfo();
        
        //prepare and output result
        $result             = $user->getDetails();
        $result['email']    = $info['email'];
        $result['username'] = $info['username'];
        echo json_encode($result);
        break;

    case "addRole": 
        $res = $db->select("SELECT * FROM `as_user_roles` WHERE `role` = :r", array( 'r' => $_POST['role'] ));
        if(count($res) == 0) {
            $db->insert("as_user_roles", array("role" => strtolower($_POST['role'])));
            $result = array(
                "status" => "success",
                "roleId" => $db->lastInsertId()
            );
        }
        else {
            $result = array(
                "status" => "error",
                "message" => "Role already exists."
            );
        }
        echo json_encode($result);
        break;

    case "deleteRole": 
        //default user roles can't be deleted
        if(in_array($_POST['roleId'], array(1,2,3)) )
            exit();

        $db->delete("as_user_roles", "role_id = :id", array(
            "id" => $_POST['roleId']
        ));
        $db->update("as_users", array( 'user_role' => "1" ), "user_role = :r", array( "r" => $_POST['roleId'] ) );
        break;
        
	
	default:
		
		break;
}