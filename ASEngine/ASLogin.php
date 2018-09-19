<?php
/**
 * User login class.
 *
 */
class ASLogin extends ASDatabase {
    
    function __construct() {
        //connect to database
        parent::__construct(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
    
    
    /**
     * Check if user is logged in.
     * @return boolean TRUE if user is logged in, FALSE otherwise.
     */
    public function isLoggedIn() {
        //if $_SESSION['user_id'] is not set return false
        if(ASSession::get("user_id") == null)
             return false;
        
        //if enabled, check fingerprint
        if(LOGIN_FINGERPRINT == true) {
            $loginString  = $this->_generateLoginString();
            $currentString = ASSession::get("login_fingerprint");
            if($currentString != null && $currentString == $loginString)
                return true;
            else  {
                //destroy session, it is probably stolen by someone
                $this->logout();
                return false;
            }
        }
        
        //if you got to this point, user is logged in
        return true;        
    }
    
    
    /**
     * Login user with given username and password.
     * @param string $username User's username.
     * @param string $password User's password.
     * @return boolean TRUE if login is successful, FALSE otherwise
     */
    public function userLogin($username, $password) {
        //validation
        $errors = $this->_validateLoginFields($username, $password);
        if(count($errors) != 0) {
            $result = implode("<br />", $errors);
            echo $result;
        }
        
        //protect from brute force attack
        if($this->_isBruteForce()) {
            echo ERROR_BRUTE_FORCE;
            return;
        }
        
        //hash password and get data from db
        $password = $this->_hashPassword($password);
        $result = $this->select(
                    "SELECT * FROM `as_users`
                     WHERE `username` = :u AND `password` = :p",
                     array(
                       "u" => $username,
                       "p" => $password
                     )
                  );
        
        if(count($result) == 1) {
            if($result[0]['confirmed'] == "N") {
                echo ERROR_USER_NOT_CONFIRMED;
                return false;
            }
            //user exist, log him in if he is confirmed
            $this->_updateLoginDate($result[0]['user_id']);
            ASSession::set("user_id", $result[0]['user_id']);
            if(LOGIN_FINGERPRINT == true)
                ASSession::set("login_fingerprint", $this->_generateLoginString ());
            
            return true;
        }
        else {
            //wrong username/password combination
            $this->_increaseLoginAttempts();
            echo ERROR_WRONG_USERNAME_PASSWORD;
            return false;
        }
    }
    
    
    /**
     * Log out user and destroy session.
     */
    public function logout() {
        ASSession::destroySession();
    }
    
    
        
    /* PRIVATE AREA
     =================================================*/
    
    /**
     * Validate login fields
     * @param string $username User's username.
     * @param string $password User's password.
     * @return array Array with errors if there are some, empty array otherwise.
     */
    private function _validateLoginFields($username, $password) {
        $id     = $_POST['id'];
        $errors = array();
        
        if($username == "")
            $errors[] = ERROR_USERNAME_REQUIRED;
        
        if($password == "")
            $errors[] = ERROR_PASSWORD_REQUIRED;
        
        return $errors;
    }
    
    /**
     * Generate string that will be used as fingerprint. 
     * This is actually string created from user's browser name and user's IP 
     * address, so if someone steal users session, he won't be able to access.
     * @return string Generated string.
     */
    private function _generateLoginString() {
        $userIP = $_SERVER['REMOTE_ADDR'];
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginString = hash('sha512',$userIP.$userBrowser);
        return $loginString;
    }
    
    
    /**
     * Increase login attempts from specific IP address to preven brute force attack.
     */
    private function _increaseLoginAttempts() {
        $date    = date("Y-m-d");
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $table   = 'as_login_attempts';
       
        //get current number of attempts from this ip address
        $loginAttempts = $this->_getLoginAttempts();
        
        //if they are greater than 0, update the value
        //if not, insert new row
        if($loginAttempts > 0)
            $this->update (
                        $table, 
                        array( "attempt_number" => $loginAttempts + 1 ), 
                        "`ip_addr` = :ip_addr AND `date` = :d", 
                        array( "ip_addr" => $user_ip, "d" => $date)
                      );
        else
            $this->insert($table, array(
                "ip_addr" => $user_ip,
                "date"    => $date
            ));
    }
    
    /**
     * Get number of login attempts from user's IP address.
     * @return int Number of login attempts.
     */
    private function _getLoginAttempts() {
        $date = date("Y-m-d");
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
         $query = "SELECT `attempt_number`
                   FROM `as_login_attempts`
                   WHERE `ip_addr` = :ip AND `date` = :date";
                      
         
        $result = $this->select($query, array(
            "ip"    => $user_ip,
            "date"  => $date
        ));
        if(count($result) == 0)
            return 0;
        else
            return intval($result[0]['attempt_number']);
    }
    
    /**
     * Check if someone is trying to break password with brute force attack.
     * @return TRUE if number of attemts are greater than allowed, FALSE otherwise.
     */
    private function _isBruteForce() {
        $loginAttempts = $this->_getLoginAttempts();
        if($loginAttempts > LOGIN_MAX_LOGIN_ATTEMPTS)
            return true;
        else
            return false;
    }
    
    /**
     * Hash user's password using salt.
     * @param string $password Unhashed password.
     * @return string Hashed password
     */
    private function _hashPassword($password) {
        $register = new ASRegister();
        return $register->hashPassword($password);
    }
    
    
    /**
     * Update database with login date and time when this user is logged in.
     * @param int $userid Id of user that is logged in.
     */
    private function _updateLoginDate($userid) {
        $this->update(
                    "as_users",
                    array("last_login" => date("Y-m-d H:i:s")),
                    "user_id = :u",
                    array( "u" => $userid)
                );
    }
    
}

