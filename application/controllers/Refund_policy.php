<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund_policy extends CI_Controller {
    
    
    public function __construct() {
    
        parent::__construct();
        $this->lang->load('header');
        $this->load->helper('url');
        $this->load->model('log_model');
        $this->load->model('users_model');
    }
    
    public function index()
    {
        $this->load->view('page.refund_policy.php');
    }
}
