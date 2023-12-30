<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    /**
     * @var string what table is used in the database for the users
     */
    public $_subscriptions_table= 'subscriptions';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    public $configs = array();
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    public function __construct() {
        parent::__construct();
        $this->lang->load('users');
        
        $general_config = $this->users_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = lang('users');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.users.php', $tmpl);
    }

    public function view($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('users','view');
        
        if($url){
            $users_details = $this->users_model->get_where($this->_users_table,array('rand_id'=>$url)); 
            if(!empty($users_details)){
                $tmpl = array();
                $tmpl['users_details'] = $users_details;
                $tmpl['subscription_plans'] = $this->users_model->get_where($this->_subscriptions_table,array());
                $tmpl['page_title'] = $users_details[0]['first_name'];
                $tmpl['configs'] = $this->configs;
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_user.php',$tmpl);
            }
            else{
                redirect(site_url().DASHBOARD_DIR_NAME.'users/');
            }            
        }
        else{
            redirect(site_url().DASHBOARD_DIR_NAME.'users/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('users','edit');
        
        if($url){
            $users_details = $this->users_model->get_where($this->_users_table,array('rand_id'=>$url)); 
            $users_types = $this->users_model->get_where($this->_users_types_table,array('visibility'=>'1','deleted'=>'0')); 
            
            if(!empty($users_details)){
                $tmpl = array();
                $tmpl['users_details'] = $users_details;
                $tmpl['users_types'] = $users_types;
                $tmpl['page_title'] = $users_details[0]['users_title'];
                $tmpl['topics'] = $this->users_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['users_topics'] = $this->users_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS,'entity_id'=>$users_details[0]['users_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_users.php',$tmpl);
            }
            else{
                 redirect(site_url().DASHBOARD_DIR_NAME.'users/');
            }            
        }
        else{
            redirect(site_url().DASHBOARD_DIR_NAME.'users/');
        }        
    }
}
