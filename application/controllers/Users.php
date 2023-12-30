<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';
   
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_types_table= 'news_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    
    public $configs = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
        $this->lang->load('users');
        $this->load->model('users_model');        
        $this->load->model('news_model');        
        
        $this->load->model('permissions_model');
        $this->load->model('localization_model');
        $this->load->model('email_notification_model');
        
        $general_config = $this->users_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
        date_default_timezone_set($this->configs['timezone']);
    }
    
    public function index()
    {
        $tmpl = array();
        $this->load->view('page.home.php',$tmpl);
    }
    
    public function verify_email($token)
    {
        if($token){
            $user_id = $this->users_model->update_user_details($this->_users_table,array('email_verified'=>'1'),array('email_verification_token'=>$token)); 
            if($user_id){
                $this->log_model->add('info', "User email verified. User ID(".$user_id.")");
            }
            else{
                $this->log_model->add('error', "User email verification failed. Token(".$token.")");
            }
            $this->load->view('page.email_verification_thanks.php');
        }
        else{
            redirect(site_url());
        }
    }
    
    public function reset_password($token)
    {
        if($token){
            $user_details = $this->users_model->get_where_now($token); 
            $tmpl = array();
            if(!empty($user_details)){
                $tmpl['user_id'] = $user_details[0]['user_id'];
                $tmpl['rand_id'] = $user_details[0]['rand_id'];
                $tmpl['page_title'] = lang('change_password');
            }
            else{
                $tmpl['error'] = lang('it_seems_your_reset_password_link_has_been_expired');
                $tmpl['page_title'] = lang('it_seems_your_reset_password_link_has_been_expired');
            }
            $this->load->view('page.change_password.php', $tmpl);
        }
        else{
            redirect(site_url());
        }
    }
    
    public function open_app_for_login()
    {    
        $tmpl = array();
        $tmpl['page_title'] = lang('open_app_for_login');
        $this->load->view('page.open_app_for_login.php', $tmpl);        
    }
}
