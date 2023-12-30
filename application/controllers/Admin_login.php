<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
    }
    public function index() {
        if($this->session->userdata('ds_user')){
            redirect(site_url().DASHBOARD_DIR_NAME, 'refresh');
        }
        else{
            $this->load->view('page.login.php');
        }
    }
    public function logout()
    {
        // write to system log
        $this->log_model->add('logout', "User logout successfully. User ID(".$this->session->userdata('ds_user').")");
        
        session_destroy();
        redirect(site_url().'admin_login', 'refresh');
    }
}
