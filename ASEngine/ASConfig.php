<?php

//DATABASE CONFIGURATION
define('DB_USER', "oxo_expusr");
define('DB_PASS', "PAqtqmfra9uE");
define('DB_NAME', "oxo_explorer");
define('DB_HOST', "localhost");
define('DB_TYPE', "mysql");



//BOOTSTRAP

define('BOOTSTRAP_VERSION', 3);

// Turn off all error reporting
// error_reporting(E_ALL);

error_reporting(-1);
ini_set('display_errors', 'On');

//WEBSITE

define('WEBSITE_NAME', "OXO Solutions");

define('TAGLINE', "Admin Panel");

define('COMPANY', "OXO Solutions");

define('WEBSITE_DOMAIN', "oxosolutions.com");

define('THEME_COLOR', "blue");




//SESSION CONFIGURATION

define('SESSION_NAME',"app_session");   

define('SESSION_SECURE', false);   

define('SESSION_HTTP_ONLY', true);

define('SESSION_REGENERATE_ID', true);   

define('SESSION_USE_ONLY_COOKIES', 1);


//LOGIN CONFIGURATION

define('LOGIN_MAX_LOGIN_ATTEMPTS', 8); 

define('LOGIN_FINGERPRINT', true); 


//PASSWORD CONFIGURATION

define('PASSWORD_ENCRYPTION', "bcrypt"); //available values: "sha512", "bcrypt"

define('PASSWORD_BCRYPT_COST', "14"); 

define('PASSWORD_SHA512_ITERATIONS', 25000); 

define('PASSWORD_SALT', "PttYUveXqhDKFXtIY0tBqD"); //22 characters to be appended on first 7 characters that will be generated using PASSWORD_ info above


//REGISTRATION CONFIGURATION

define('REGISTER_CONFIRM', "oxosolutions.com/admin/confirm.php"); 

define('REGISTER_PASSWORD_RESET', "oxosolutions.com/admin/passwordreset.php"); 


//ERROR MESSAGES

define('ERROR_EMAIL_REQUIRED', "Email is required.");

define('ERROR_EMAIL_WRONG_FORMAT', "Please enter valid email.");

define('ERROR_EMAIL_NOT_EXIST', "This email doesn't exist in our database.");

define('ERROR_EMAIL_TAKEN',"User with this email is already registred.");

define('ERROR_USERNAME_REQUIRED', "Username is required.");

define('ERROR_USERNAME_TAKEN', "Username already in use.");

define('ERROR_USER_NOT_CONFIRMED', "Please confirm your email.");

define('ERROR_PASSWORD_REQUIRED', "Password is required.");

define('ERROR_WRONG_USERNAME_PASSWORD', "Wrong username/password combination.");

define('ERROR_PASSWORDS_DONT_MATCH', "Passwords don't match.");

define('ERROR_WRONG_SUM', "Wrong sum. Please check it again.");

define('ERROR_BRUTE_FORCE', "You exceeded maximum attempts limit for today. Try again tomorrow.");


//SUCCESS MESSAGES

define('SUCCESS_REGISTRATION', "Registration successful. Please check your email.");