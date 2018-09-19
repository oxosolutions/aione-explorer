<?php 
/**
 * User class.
 */
class ASUser extends ASDatabase {
    
    //id of user represented by this class
    private $userId;

    function __construct($userId) {
        //update local user id with given user id
        $this->userId = $userId;
        
        //connect to database
        parent::__construct(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
    
    /**
     * Set user id if new one is provided, return old one otherwise.
     * @param int $newId New user id.
     * @return int Returns new user id if it is provided, old user id otherwise.
     */
    public function id($newId = null) {
        if($newId != null)
            $this->userId = $newId;
        return $this->userId;
    }

    /**
     * Check if user is admin.
     * @return boolean TRUE if user is admin, FALSE otherwise.
     */
    public function isAdmin() {
        $role = $this->getRole();
        if($role == "admin")
            return true;
        return false;
    }

    /**
     * Updates user's password.
     * @param string $oldPass Old password.
     * @param string $newPass New password.
     */
    public function updatePassword($oldPass,$newPass) {

        //hash both passwords
        $oldPass = $this->_hashPassword($oldPass);
        $newPass = $this->_hashPassword($newPass);
        
        //get user info (email, password etc)
        $info = $this->getInfo();
        
        //update if entered old password is correct
        if($oldPass == $info['password']){
            $this->updateInfo(array( "password" => $newPass ));
            return true;  
        } else {
            return false;
        }
    }

    /**
     * Updates user's password.
     * @param string $oldPass Old password.
     * @param string $newPass New password.
     */
    public function validatePassword($password,$confirmPassword) {
        //Chech if both the passwords match
        if($password == $confirmPassword){
            return true;
        } else {
            return false; 
        }
    }

    /**
     * Changes user's role. If user's role was editor it will be set to user and vice versa.
     * @return string New user role.
     */
    public function changeRole() {
        $role = $_POST['role'];

        $result = $this->select("SELECT * FROM `as_user_roles` WHERE `role_id` = :r", array( "r" => $role ));

        if(count($result) == 0)
            return;

        $this->updateInfo(array( "user_role" => $role ));

        return $result[0]['role'];
    }

    /**
     * Get current user's role.
     * @return string Current user's role.
     */
    public function getRole() {
        $result = $this->select(
                      "SELECT `as_user_roles`.`role` as role 
                       FROM `as_user_roles`,`as_users`
                       WHERE `as_users`.`user_role` = `as_user_roles`.`role_id`
                       AND `as_users`.`user_id` = :id",
                       array( "id" => $this->userId)
                    );

        return $result[0]['role'];
    }

    /**
     * Get basic user info provided during registration.
     * @return array User info array.
     */
    public function getInfo() {
        $result = $this->select(
                    "SELECT * FROM `as_users` WHERE `user_id` = :id",
                    array ("id" => $this->userId)
                  );

        return $result[0];
    }


    /**
     * Updates user info.
     * @param array $updateData Associative array where keys are database fields that need
     * to be updated and values are new values for provided database fields.
     */
    public function updateInfo($updateData) {
        $this->update(
                    "as_users", 
                    $updateData, 
                    "`user_id` = :id",
                    array( "id" => $this->userId )
               );
    }

    
    /**
     * Get user details (First Name, Last Name, Address and Phone)
     * @return array User details array.
     */
    public function getDetails() {
        $result = $this->select(
            "SELECT * FROM `as_user_details` WHERE `user_id` = :id",
            array ("id" => $this->userId)
          );
        if(count($result) == 0)
            return array(
                "first_name" => "",
                "last_name"  => "",
                "address"    => "",
                "phone"      => "",
                "empty"      => true
            );
        return $result[0];
    }

    
    /**
     * Updates user details.
     * @param array $details Associative array where keys are database fields that need
     * to be updated and values are new values for provided database fields.
     */
    public function updateDetails($details) {
        $currDetails = $this->getDetails();
        if(isset($currDetails['empty'])) {
            $details["user_id"] = $this->userId;
            $this->insert("as_user_details", $details);
        }
        else
            $this->update(
                        "as_user_details", 
                        $details, 
                        "`user_id` = :id",
                        array( "id" => $this->userId )
                   );
    }

    
    /**
     * Delete user and all his comments.
     */
    public function deleteUser() {
        $this->delete("as_users", "user_id = :id", array( "id" => $this->userId ));
        $this->delete("as_user_details","user_id = :id", array( "id" => $this->userId ));
    }

    
     /* PRIVATE AREA
     =================================================*/
    
    /**
     * Hash provided password.
     * @param string $password Password that needs to be hashed.
     * @return string Hashed password.
     */
    private function _hashPassword($password) {
        $register = new ASRegister();
        return $register->hashPassword($password);
    }
}
    
 ?>