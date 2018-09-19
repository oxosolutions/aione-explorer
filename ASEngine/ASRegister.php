<?php

/**
 * User registration class.
 *
 */
class ASRegister extends ASDatabase{
    
    //local ASEmail object
    private $mailer;
    
    function __construct() {
       
        //connect to database
        parent::__construct(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        
        //create new object of ASEmail class
        $this->mailer = new ASEmail();
    }
    
    /**
     * Register user.
     * @param array $data User details provided during the registration process.
     */
    public function register($data) {
        $user = $data['userData'];
        
        //validate provided data
        $errors = $this->_validateUser($data);
        
        if(count($errors) == 0) {
            //no validation errors
            
            //generate email confirmation key
            $key = $this->_generateKey();
            
            //insert new user to database
            $this->insert('as_users', array(
                "email"     => $user['email'],
                "username"  => $user['username'],
                "password"  => $this->hashPassword($user['password']),
                "confirmation_key"  => $key,
                "register_date"     => date("Y-m-d")     
            ));
            
            //send confirmation email
            $this->mailer->confirmationEmail($user['email'], $key);
            
            //prepare and output success message
            $result = array(
                "status" => "success",
                "msg"    => SUCCESS_REGISTRATION
            );
            
            echo json_encode($result);
        }
        else {
            //there are validation errors
            
            //prepare result
            $result = array(
                "status" => "error",
                "errors" => $errors
            );
            
            //output result
            echo json_encode ($result);
        }
    }
    
    /**
     * Check if user with given username exist.
     * @param string $username Given username.
     * @return boolean TRUE if user already exist, false otherwise.
     */
    public function doesUserExist($username) {
        if(!$this->_isUsernameAvailable($username))
            return true;
        return false;
    }
    
    
    /**
     * Check if email already exist in database.
     * @param string $email Email to check.
     * @return boolean TRUE if email exist, FALSE otherwise
     */
    public function doesEmailExist($email) {
        return !$this->_isEmailAvailable($email);
    }
    
    
    /**
     * Send forgot password email.
     * @param string $userEmail Provided email.
     */
    public function forgotPassword($userEmail) {
        //we only have one field to validate here
        //so we don't need id's from other fields
        if($userEmail == "")
            $errors[] = ERROR_EMAIL_REQUIRED;
        if(!$this->_validateEmail($userEmail))
            $errors[] = ERROR_EMAIL_WRONG_FORMAT;
        
        if($this->doesEmailExist($userEmail) == false)
            $errors[] = ERROR_EMAIL_NOT_EXIST;
        
        if(count($errors) == 0) {
            //no validation errors
            
            //generate password reset key
            $key = $this->_generateKey();
            
            //write key to db
            $this->update(
                        'as_users', 
                         array("password_reset_key" => $key), 
                         "`email` = :email",
                         array("email" => $userEmail)
                    );
            
            //send email
            $this->mailer->passwordResetEmail($userEmail, $key);
        }
        else
            echo json_encode ($errors); //output json encoded errors
    }
    
    
    /**
     * Reset user's password if password reset request has been made.
     * @param string $newPass New password.
     * @param string $passwordResetKey Password reset key sent to user
     * in password reset email.
     */
    public function resetPassword($newPass, $passwordResetKey) {
        $pass = $this->hashPassword($newPass);
        $this->update(
                    'as_users', 
                    array("password" => $pass), 
                    "`password_reset_key` = :prk ",
                    array("prk" => $passwordResetKey)
                );
    }
    
     
    /**
     * Hash given password.
     * @param string $password Unhashed password.
     * @return string Hashed password.
     */
     public function hashPassword($password) {
        //this salt will be used in both algorithms
        //for bcrypt it is required to look like this,
        //for sha512 it is not required but it can be used 
        $salt = "$2a$" . PASSWORD_BCRYPT_COST . "$" . PASSWORD_SALT;
        
        if(PASSWORD_ENCRYPTION == "bcrypt") {
            $newPassword = crypt($password, $salt);
        }
        else {
            $newPassword = $password;
            for($i=0; $i<PASSWORD_SHA512_ITERATIONS; $i++)
                $newPassword = hash('sha512',$salt.$newPassword.$salt);
        }
        
        return $newPassword;
     }
    
    
    /**
     * Generate two random numbers and store them into $_SESSION variable.
     * Numbers are used during the registration to prevent bots to register.
     */
     public function botProtection() {
        ASSession::set("bot_first_number", rand(1,9));
        ASSession::set("bot_second_number", rand(1,9));
    }
    
    
     /* PRIVATE AREA
     =================================================*/
    
    
    /**
     * Validate user provided fields.
     * @param array $data User provided fieds and id's of those fields that will 
     * be used for displaying error messages on client side.
     * @return array Array with errors if there are some, empty array otherwise.
     */
    private function _validateUser($data) {
        $id     = $data['fieldId'];
        $user   = $data['userData'];
        $errors = array();
        
        //check if email is not empty
        if($user['email'] == "")
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ERROR_EMAIL_REQUIRED 
            );
        
        //check if username is not empty
        if($user['username'] == "")
            $errors[] = array( 
                "id"    => $id['username'],
                "msg"   => ERROR_USERNAME_REQUIRED
            );
        
        //check if password is not empty
        if($user['password'] == "")
            $errors[] = array( 
                "id"    => $id['password'],
                "msg"   => ERROR_PASSWORD_REQUIRED
            );
        
        //check if password and confirm password are the same
        if($user['password'] != $user['confirm_password'])
            $errors[] = array( 
                "id"    => $id['confirm_password'],
                "msg"   => ERROR_PASSWORDS_DONT_MATCH
            );
        
        //check if email format is correct
        if(!$this->_validateEmail($user['email']))
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ERROR_EMAIL_WRONG_FORMAT
            );
        
        //check if email is available
        if($this->_isEmailAvailable($user['email']) == false)
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ERROR_EMAIL_TAKEN
            );
        
        //check if username is available
        if($this->_isUsernameAvailable($user['username']) == false )
            $errors[] = array( 
                "id"    => $id['username'],
                "msg"   => ERROR_USERNAME_TAKEN
            );
        
        //bot protection
        $sum = ASSession::get("bot_first_number") + ASSession::get("bot_second_number");
        if($sum != intval($user['bot_sum']))
            $errors[] = array( 
                "id"    => $id['bot_sum'],
                "msg"   =>ERROR_WRONG_SUM
            );
        
        
        return $errors;
    }
    
    
    /**
     * Check if email is available.
     * @param string $email Email to be checked.
     * @return boolean TRUE if email is available, FALSE otherwise
     */
    private function _isEmailAvailable($email) {
        $query = "SELECT * FROM `as_users` WHERE `email` = :e ";
        $result = $this->select($query, array( "e" => $email ));
        if(count($result) == 0)
            return true;
        else
            return false;
    }
    
    
    /**
     * Check if username is available.
     * @param string $un Username to check.
     * @return boolean TRUE if username is available, FALSE otherwise.
     */
    private function _isUsernameAvailable($un) {
        $query = "SELECT * FROM `as_users` WHERE `username` = :u ";
        $result = $this->select($query, array( "u" => $un ));
        if(count($result) == 0)
            return true;
        else
            return false;
    }
    
    
    /**
     * Check if email has valid format.
     * @param string $email Email to be checked.
     * @return boolean TRUE if email has valid format, FALSE otherwise.
     */
    private function _validateEmail($email) {
        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
    }
    
    
    /**
     * Generate key used for confirmation and password reset.
     * @return string Generated key.
     */
    private function _generateKey() {
        return md5(time() . LOGIN_SALT . time());
    }
    
   
}

?>
