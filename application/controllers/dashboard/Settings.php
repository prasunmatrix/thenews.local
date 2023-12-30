<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    /**
     * @var string what table is used in the database for the topics
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_topic_entities_table= 'topic_entities_trans';

    /**
     * @var string what table is used in the database for the topics
     */
    public $_menu_items_table= 'menu_items';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_menu_sub_items_table= 'menu_sub_items';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_terms_and_conditions_table = 'terms_and_conditions';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */    
    public $_privacy_and_policy_table = 'privacy_and_policy';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_about_us_table = 'about_us';
    
    public function __construct() {
        parent::__construct();
        $this->lang->load('settings');
        $this->load->model('settings_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');

        
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = "Settings";
        $this->load->view(DASHBOARD_DIR_NAME . '/page.settings.php',$tmpl);
    }
    public function about_us() {
        $tmpl = array();
        $tmpl['page_title'] = lang('about_us');
        $tmpl['about_us'] = $this->settings_model->get_where($this->_about_us_table,array('id'=>'1'));
        $this->load->view(DASHBOARD_DIR_NAME . '/page.about_us.php',$tmpl);
    }
    public function privacy_policy() {
        $tmpl = array();
        $tmpl['page_title'] = lang('privacy_policy');
        $tmpl['privacy_policy'] = $this->settings_model->get_where($this->_privacy_and_policy_table,array('id'=>'1'));
        $this->load->view(DASHBOARD_DIR_NAME . '/page.privacy_policy.php',$tmpl);
    }
    public function terms_and_conditions() {
        $tmpl = array();
        $tmpl['page_title'] = lang('terms_and_conditions');
        $tmpl['terms'] = $this->settings_model->get_where($this->_terms_and_conditions_table,array('id'=>'1'));
        $this->load->view(DASHBOARD_DIR_NAME . '/page.terms_and_conditions.php',$tmpl);
    }
        
    public function topics($operation = FALSE, $params = FALSE)
    {
        
        if($operation=='add'){
            //check permissions
            $this->permissions_model->check_redirect('topics','add');
            $tmpl = array();
            $tmpl['page_title'] = lang('add_new_topic');
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_topic.php',$tmpl);
        }
        else if($operation=='edit' && $params != FALSE){
            //check permissions
            $this->permissions_model->check_redirect('topics','edit');

            $tmpl = array(); 
            $tmpl['page_title'] = lang('edit_topic_details');
            $tmpl['topic_details'] = $this->settings_model->get_where($this->_topics_table,array('rand_id'=>$params));
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_topic.php',$tmpl);
        }
        else if($operation==''){
            //check permissions
            $this->permissions_model->check_redirect('topics','index');

            $tmpl = array(); 
            $tmpl['page_title'] = lang('topics');
            $this->load->view(DASHBOARD_DIR_NAME.'page.topics.php',$tmpl);
        }        
    }
    
    public function menu_items($operation = FALSE, $params = FALSE)
    {
        
        if($operation=='add'){
            //check permissions
            $this->permissions_model->check_redirect('menu_items','add');
            $tmpl = array(); 
            $tmpl['page_title'] = lang('add_new_menu_item'); 
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_menu_item.php',$tmpl);
        }
        else if($operation=='edit' && $params != FALSE){
            //check permissions
            $this->permissions_model->check_redirect('menu_items','edit');

            $tmpl = array(); 
            $tmpl['page_title'] = lang('edit_menu_item_details'); 
            $tmpl['menu_item_details'] = $this->settings_model->get_where($this->_menu_items_table,array('rand_id'=>$params));
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_menu_item.php',$tmpl);
        }
        else if($operation=='view' && $params != FALSE){
            //check permissions
            $this->permissions_model->check_redirect('menu_items','view');

            $tmpl = array(); 
            $tmpl['menu_item_details'] = $this->settings_model->get_where($this->_menu_items_table,array('rand_id'=>$params));
            $tmpl['page_title'] = $tmpl['menu_item_details'][0]['item_title']; 
            $this->load->view(DASHBOARD_DIR_NAME.'page.view_menu_item.php',$tmpl);
        }
        else if($operation==''){
            //check permissions
            $this->permissions_model->check_redirect('menu_items','index');

            $tmpl = array(); 
            $tmpl['page_title'] = lang('menu_items');
            $this->load->view(DASHBOARD_DIR_NAME.'page.menu_items.php',$tmpl);
        }        
    }
    
    public function menu_sub_items() {
        $tmpl = array();
        $tmpl['page_title'] = "Menu sub Items";
        $this->load->view(DASHBOARD_DIR_NAME . '/page.menu_sub_items.php',$tmpl);
    }
    
    public function educational_institutes($operation = FALSE, $params = FALSE) {
        if($operation=='add'){
            //check permissions
            $this->permissions_model->check_redirect('educational_institutes','add');
            $tmpl = array();
            $tmpl['page_title'] = lang('add_new_educational_institute');
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_educational_institute.php',$tmpl);
        }
        else if($operation=='edit' && $params != FALSE){
            //check permissions
            $this->permissions_model->check_redirect('educational_institutes','edit');

            $tmpl = array(); 
            $tmpl['educational_institute_details'] = $this->settings_model->get_where($this->_educational_institutes_table,array('inst_rand_id'=>$params));
            $tmpl['page_title'] = $tmpl['educational_institute_details'][0]['inst_name'];
            $this->load->view(DASHBOARD_DIR_NAME.'page.add_new_educational_institute.php',$tmpl);
        }
        else if($operation=='view' && $params != FALSE){
            //check permissions
            $this->permissions_model->check_redirect('educational_institutes','view');

            $tmpl = array(); 
            $tmpl['educational_institute_details'] = $this->settings_model->get_where($this->_educational_institutes_table,array('inst_rand_id'=>$params));
            $tmpl['page_title'] = $tmpl['educational_institute_details'][0]['inst_name'];
            $this->load->view(DASHBOARD_DIR_NAME.'page.view_educational_institute.php',$tmpl);
        }
        else if($operation==''){
            //check permissions
            $this->permissions_model->check_redirect('educational_institutes','index');

            $tmpl = array();
            $tmpl['page_title'] = lang('educational_institutes');
            $this->load->view(DASHBOARD_DIR_NAME . '/page.educational_institutes.php',$tmpl);
        }        
    
    }

}
