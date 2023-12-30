<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        
        parent::__construct();
        
    }
    public function index() {
        if($this->session->userdata('normal_user')){
            redirect(site_url().USER_PROFILE_DIR_NAME, 'refresh');
        }
        else{
            $this->load->view('page.users_login.php');
        }
    }
    public function register() {
        if($this->session->userdata('normal_user')){
            redirect(site_url().USER_PROFILE_DIR_NAME, 'refresh');
        }
        else{
            $this->load->view('page.register.php');
        }
    }
    public function forgot_password() {
        if($this->session->userdata('normal_user')){
            redirect(site_url().USER_PROFILE_DIR_NAME, 'refresh');
        }
        else{
            $this->load->view('page.forgot_password.php');
        }
    }
    public function logout()
    {
        // write to system log
        $this->log_model->add('logout', "User logout successfully. User ID(".$this->session->userdata('ds_user').")");
        
        session_destroy();
        redirect(site_url().'admin_login', 'refresh');
    }
    
    public function impersonate($user_rand_id = FALSE){
        if($user_rand_id){
            //check if user id exists
            $user_details = $this->users_model->get_where("users", array("rand_id"=>$user_rand_id));
            // echo "<pre>";
            // print_r($user_details); die;

            if(!empty($user_details)){
                $this->session->set_userdata('normal_user', $user_details[0]['user_id']);
                $this->session->set_userdata('normal_subscribed_plan', $user_details[0]['subscribed_plan_id']);
                $this->session->set_userdata('normal_subscription_end_date', $user_details[0]['subscription_end_date']);
                redirect(site_url(), 'refresh');
            }
            else{
                redirect(site_url(), 'refresh');
            }
        }
        else{
            redirect(site_url(), 'refresh');
        }
    }
}
