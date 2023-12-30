<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';

    /**
     * @var string what table is used in the database for the users
     */
    public $_subscriptions_table= 'subscriptions';
    
    public $configs = array();
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->model('users_model');        
        $this->load->model('log_model');
        $this->load->model('permissions_model');
        $this->load->model('localization_model');
        $this->load->model('email_notification_model');
        $this->lang->load('header');
        $this->lang->load('profile');
        
        $general_config = $this->users_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
    }
    public function index() {
        if($this->session->userdata('normal_user')){
            
            setcookie('loggedin_user_id', $this->session->userdata('normal_user'), time() + (86400 * 30), "/"); // 86400 = 1 day
            
            $tmpl = array();
            $tmpl['profile_details'] = $this->users_model->get_where($this->_users_table,array('user_id'=>$this->session->userdata('normal_user')));
            if(!empty($tmpl['profile_details'])){
                $this->session->set_userdata('normal_subscribed_plan', $tmpl['profile_details'][0]['subscribed_plan_id']);
                $this->session->set_userdata('normal_subscription_end_date', $tmpl['profile_details'][0]['subscription_end_date']);
                
                $tmpl['page_title'] = $tmpl['profile_details'][0]['first_name'];
                $tmpl['subscriptions'] = $this->users_model->get_where($this->_subscriptions_table,array());
                $tmpl['bookmarks_news'] = $this->users_model->get_user_bookmarks_news($this->session->userdata('normal_user'));
                $tmpl['bookmarks_videos'] = $this->users_model->get_user_bookmarks_videos($this->session->userdata('normal_user'));
                
                $tmpl['configs'] = $this->configs;
                $this->load->view('page.user_profile.php',$tmpl);
            }
            else{
                redirect(site_url().'profile/logout', 'refresh');
            }
        }
        else{
            if(isset($_COOKIE['loggedin_user_id'])){
                $this->session->set_userdata('normal_user', $_COOKIE['loggedin_user_id']);
                redirect(site_url().'profile', 'refresh');
            }
            else{
                redirect(site_url().'login', 'refresh');
            }
        }
    }
    public function subscription($action = FALSE, $plan_id = FALSE) {
        
        if($this->session->userdata('normal_user')){
            if($action=='success'){
                if($plan_id=="1"||$plan_id==1){
                    $subscription_end_date = date("Y-m-d", strtotime("+1 month", time()));
                }
                if($plan_id=="2"||$plan_id==2){
                    $subscription_end_date = date("Y-m-d", strtotime("+3 month", time()));
                }
                if($plan_id=="3"||$plan_id==3){
                    $subscription_end_date = date("Y-m-d", strtotime("+6 month", time()));
                }
                if($plan_id=="4"||$plan_id==4){
                    $subscription_end_date = date("Y-m-d", strtotime("+12 month", time()));
                }
                $this->session->set_userdata('normal_subscribed_plan', $plan_id);
                $this->session->set_userdata('normal_subscription_end_date', $subscription_end_date);
                $subscription_plan_id = $plan_id;
                $subscription_payment_id = "";
                if(isset($_REQUEST['payment_id'])){
                    $subscription_payment_id = $_REQUEST['payment_id'];
                }
                $res = $this->users_model->update_user_details($this->_users_table,array('subscription_payment_id'=>$subscription_payment_id,'subscription_end_date'=>$subscription_end_date,'subscribed_plan_id'=>$subscription_plan_id),array('user_id'=>$this->session->userdata('normal_user')));
                if($res){
                    $email_status = $this->email_notification_model->send_subscription_details($res, $subscription_end_date, $subscription_payment_id);
                    if($email_status){
                        $this->log_model->add('info', "User subscription email sent successfully. User ID(".$res.")");
                    }
                    else{
                        $this->log_model->add('error', "User subscription email could not be sent. User ID(".$res.")");
                    }
                    
                    $this->log_model->add('info', "User subscribed successfully, User IS(".$res."), Subscription Plan ID(" . $subscription_plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
                }
                else{
                    $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, User ID(".$res."), Subscription Plan ID(" . $subscription_plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
                }
                $tmpl = array();
                $tmpl['page_title'] = lang('thanks_for_subscribe');
                $tmpl['end_date'] = $subscription_end_date;
                $tmpl['payment_id'] = $subscription_payment_id;
                $tmpl['plan_id'] = $subscription_plan_id;
                $this->load->view('page.user_subscription_thanks.php',$tmpl);
            }
            else if($action==''){
                if($this->session->userdata('normal_user')){
                    setcookie('loggedin_user_id', $this->session->userdata('normal_user'), time() + (86400 * 30), "/"); // 86400 = 1 day
                }
                $tmpl = array();
                $tmpl['profile_details'] = $this->users_model->get_where($this->_users_table,array('user_id'=>$this->session->userdata('normal_user')));
                if(!empty($tmpl['profile_details'])){
                    $tmpl['page_title'] = $tmpl['profile_details'][0]['first_name'];
                    $tmpl['subscriptions'] = $this->users_model->get_where($this->_subscriptions_table,array());
                    $this->load->view('page.user_subscription.php',$tmpl);
                }
            }
        }
        else{
            if(isset($_COOKIE['loggedin_user_id'])){
                $this->session->set_userdata('normal_user', $_COOKIE['loggedin_user_id']);
                if($action=='success'){
                    if($plan_id=="1"||$plan_id==1){
                        $subscription_end_date = date("Y-m-d", strtotime("+1 month", time()));
                    }
                    if($plan_id=="2"||$plan_id==2){
                        $subscription_end_date = date("Y-m-d", strtotime("+3 month", time()));
                    }
                    if($plan_id=="3"||$plan_id==3){
                        $subscription_end_date = date("Y-m-d", strtotime("+6 month", time()));
                    }
                    if($plan_id=="4"||$plan_id==4){
                        $subscription_end_date = date("Y-m-d", strtotime("+12 month", time()));
                    }
                    $this->session->set_userdata('normal_subscribed_plan', $plan_id);
                    $this->session->set_userdata('normal_subscription_end_date', $subscription_end_date);
                    $subscription_plan_id = $plan_id;
                    $subscription_payment_id = "";
                    if(isset($_REQUEST['payment_id'])){
                        $subscription_payment_id = $_REQUEST['payment_id'];
                    }
                    $res = $this->users_model->update_user_details($this->_users_table,array('subscription_payment_id'=>$subscription_payment_id,'subscription_end_date'=>$subscription_end_date,'subscribed_plan_id'=>$subscription_plan_id),array('user_id'=>$_COOKIE['loggedin_user_id']));
                    if($res){
                        $email_status = $this->email_notification_model->send_subscription_details($res, $subscription_end_date, $subscription_payment_id);
                        if($email_status){
                            $this->log_model->add('info', "User subscription email sent successfully. User ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "User subscription email could not be sent. User ID(".$res.")");
                        }

                        $this->log_model->add('info', "User subscribed successfully, User IS(".$res."), Subscription Plan ID(" . $subscription_plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
                    }
                    else{
                        $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, User IS(".$res."), Subscription Plan ID(" . $subscription_plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
                    }
                    $tmpl = array();
                    $tmpl['page_title'] = lang('thanks_for_subscribe');
                    $tmpl['end_date'] = $subscription_end_date;
                    $tmpl['payment_id'] = $subscription_payment_id;
                    $tmpl['plan_id'] = $subscription_plan_id;
                    $this->load->view('page.user_subscription_thanks.php',$tmpl);
                }
                else if($action==''){
                    $tmpl = array();
                    $tmpl['profile_details'] = $this->users_model->get_where($this->_users_table,array('user_id'=>$_COOKIE['loggedin_user_id']));
                    if(!empty($tmpl['profile_details'])){
                        $tmpl['page_title'] = $tmpl['profile_details'][0]['first_name'];
                        $tmpl['subscriptions'] = $this->users_model->get_where($this->_subscriptions_table,array());
                        $this->load->view('page.user_subscription.php',$tmpl);
                    }
                }
            }
            else{
                redirect(site_url().'login', 'refresh');
            }
        }
    }
    
    public function logout()
    {
        // write to system log
        $this->log_model->add('logout', "User logout successfully. User ID(".$this->session->userdata('normal_user').")");
        unset($_COOKIE['loggedin_user_id']); 
        setcookie('loggedin_user_id', null, -1, '/'); 
        session_destroy();
        redirect(site_url().'login', 'refresh');
    }
}
