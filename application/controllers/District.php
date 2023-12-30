<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District extends CI_Controller {
    
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
    
    public $configs = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
        $this->lang->load('epaper');
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
        $tmpl['page_title'] = lang('districts');
        $tmpl['configs'] = $this->configs;
        $this->load->view('page.district.php',$tmpl);
    }
    
    public function view($url)
    {
        if($url){
            $topic_details = $this->news_model->get_where($this->_topics_table,array('rand_id'=>$url)); 
            if(!empty($topic_details)){
                $tmpl = array();
                $tmpl['topic_details'] = $topic_details;
                $tmpl['page_title'] = $topic_details[0]['topic_name'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_posts'] = $this->news_model->get_news_by_topic_id($topic_details[0]['topic_id'],9);
                $tmpl['configs'] = $this->configs;
                $this->load->view('page.view_district.php',$tmpl);
            }
            else{
                 redirect(site_url().'district/');
            }            
        }
        else{
            redirect(site_url().'district/');
        }
    }
}
