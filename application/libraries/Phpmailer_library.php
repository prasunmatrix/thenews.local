<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.vrpatel.in
 */

/**
 * PHPMailer_Library Class
 *
 */

class Phpmailer_library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require_once(APPPATH.'../public_html/PHPMailer/src/Exception.php');
        require_once(APPPATH.'../public_html/PHPMailer/src/PHPMailer.php');
        require_once(APPPATH.'../public_html/PHPMailer/src/SMTP.php');

        $objMail = new PHPMailer\PHPMailer\PHPMailer();
        $objMail->SetLanguage("hi", APPPATH.'../public_html/PHPMailer/language/phpmailer.lang-hi.php');
        return $objMail;
    }
}