<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {
    
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
    public $_news_table= 'news';
    
    
    public $configs = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
        $this->lang->load('news');
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
    
    public function district($url)
    {
        if($url){
            $news_details = $this->news_model->get_post_details($url); 
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $tmpl['configs'] = $this->configs;
                $tmpl['previous_post'] = $this->news_model->get_news_previous_post($news_details[0]['news_id']);
                $tmpl['next_post'] = $this->news_model->get_news_next_post($news_details[0]['news_id']);
                $this->load->view('page.view_post.php',$tmpl);
            }
            else{
                 redirect(site_url().'news/');
            }            
        }
        else{
            redirect(site_url().'news/');
        }
    }
}
