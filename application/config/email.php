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
    'set_from' => 'prasun@matrixnmedia.com',
    'smtp_user' => 'prasun@matrixnmedia.com',
    'smtp_pass' => 'bbdxbdvegfttbhgw',
    'mailtype'  => 'html',
    'charset'   => 'utf-8'
);
