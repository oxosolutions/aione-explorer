<?php

/**
 * Class for sending emails.
 *
 */
class ASEmail {
    
    /**
     * Send confirmation email
     * @param string $email Where should confirmation email be send to.
     * @param string $key Confirmation key that should be included in email body.
     */
    function confirmationEmail($email, $key) {
        $header = $this->_getHeader();
        
        $to = $email;
        
        $subject = WEBSITE_NAME . " - Registration Confirmation";

        $body  = "Thank you for registering on " . WEBSITE_NAME . ". \r\n\n";
        $body .= "Please confirm your email by clicking on the link below:\r\n";
        $body .= REGISTER_CONFIRM . "?k=" . $key . "\r\n\n";
        $body .= "Many Thanks\r\n\n";
        $body .= WEBSITE_NAME;

        mail($to, $subject, $body, $header);
    }

    /**
     * Send password reset email.
     * @param string $email Where should password reset email be send to.
     * @param string $key Password reset key that should be included in email body.
     */
    function passwordResetEmail($email, $key) {
        $header = $this->_getHeader();

        $to = $email;
        
        $subject = WEBSITE_NAME . " - Password Reset";

        $body  = "A request has been made to reset your password. \r\n\n";
        $body .= "Please click on this link below in order to reset your password:\r\n";
        $body .= REGISTER_PASSWORD_RESET . "?k=" . $key . "\r\n\n";
        $body .= "Many Thanks\r\n\n";
        $body .= WEBSITE_NAME;

        mail($to, $subject, $body, $header);
    }

    
    
    /* PRIVATE AREA
     =================================================*/
    
    /**
     * Generate email header.
     * @return string Full header that will be used for sending emails.
     */
    private function _getHeader() {
        $from      = WEBSITE_DOMAIN;
        $fromName  = WEBSITE_NAME;
        $fromEmail = "noreply@" . WEBSITE_DOMAIN;
        
        $header  = "From: $fromName <$fromEmail>\r\n";
        $header .= "Reply-To: $fromEmail\r\n";
        $header .= "Return-Path: $fromEmail\r\n";
        $header .= "Organization: $fromName\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $header .= "X-Mailer: PHP".phpversion();
        
        return $header;
    }
}

?>
