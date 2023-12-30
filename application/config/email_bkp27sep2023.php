<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['useragent'] = "PB 24";
$config['protocol'] = "mail";
$config['mailtype'] = 'html';
$config['charset']  = 'utf-8';
$config['newline']  = "\r\n";
$config['wordwrap'] = TRUE;

//SMTP & mail configuration
$config['sender_details']= array(
    'protocol'  => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'from_user_name' => 'PB 24',
    'reply_user_name' => 'PB 24',
    'set_from' => 'newspb24@gmail.com',
    'smtp_user' => 'newspb24@gmail.com',
    'smtp_pass' => 'PB24#671*',
    'mailtype'  => 'html',
    'charset'   => 'utf-8'
);
