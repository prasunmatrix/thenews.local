<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exclusive_news extends CI_Controller {
    
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
    public $_news_table= 'exclusive_news';
    
    
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
        
        $exclusive_news = $this->news_model->get_where_with_order_limit($this->_news_table,array('deleted'=>'0','visibility'=>'1','parent_news_id'=>'0'),array('news_id'=>'desc'),1);
        
        if(!empty($exclusive_news)){
            redirect(site_url().'exclusive_news/view/' . $exclusive_news[0]['rand_id']);
        }
        else{
            echo "No exclusive news found.";
        }
    }
    
    public function view($url)
    {
        if($url){
            $news_details = $this->news_model->get_exclusive_post_details($url); 
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $tmpl['news_posts'] = $this->news_model->get_where_with_order($this->_news_table,array('deleted'=>'0','visibility'=>'1','parent_news_id'=>$news_details[0]['news_id']),array('news_id'=>'desc'));
                $tmpl['configs'] = $this->configs;
                $this->load->view('page.view_exclusive_post.php',$tmpl);
            }
            else{
                 redirect(site_url().'exclusive_news/');
            }            
        }
        else{
            redirect(site_url().'exclusive_news/');
        }
    }
}
