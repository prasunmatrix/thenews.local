<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_types_table= 'news_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_table= 'news';

    /**
     * @var string what table is used in the database for the users
     */
    public $_live_news_table= 'live_news';
    
    
    public $configs = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
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
        $first_page_news_posts = $this->news_model->get_latest_posts(5, array(17));
        $tmpl['first_page_news_posts'] = $first_page_news_posts;
        $news_posts = $this->news_model->get_latest_posts(12);
        foreach($news_posts as $key=>$news){
            
            $is_exists = FALSE;
            foreach($first_page_news_posts as $fnews){
                if($fnews['news_id']==$news['news_id']){
                    $is_exists = TRUE;
                }
            }
            if($is_exists){
                array_splice($news_posts,$key,1);
            }
        }
        
        $tmpl['news_posts'] = $news_posts;
        $tmpl['categories'] = $this->news_model->get_where_with_order_limit($this->_news_types_table,array('deleted'=>'0','visibility'=>'1'),array('news_type_title'=>'asc'),3);
        
        $category_news_posts = array();
        if(!empty($tmpl['categories'])){
            foreach($tmpl['categories'] as $cat){
                $posts = $this->news_model->get_where($this->_news_table,array('deleted'=>'0','visibility'=>'1','news_type_id'=>$cat['news_type_id']));
                $category_news_posts[$cat['news_type_id']] = $posts;
            }
        }
        
        $tmpl['category_news_posts'] = $category_news_posts;
        $tmpl['all_categories'] = $this->news_model->get_where($this->_news_types_table,array('deleted'=>'0','visibility'=>'1'));
        $tmpl['exclusive_news_posts'] = $this->news_model->get_exclusive_news_posts(5);
        
        $cur_date = time();
        $past_timestamp = strtotime("-36 hours", $cur_date);
        
        $tmpl['live_news_posts'] = $this->news_model->get_live_news_posts($past_timestamp);
        
        $tmpl['recent_videos'] = $this->news_model->get_recent_videos(2);
        $tmpl['configs'] = $this->configs;
        $tmpl['last_live_news'] = $this->news_model->get_where_with_order_limit($this->_live_news_table,array('deleted'=>'0','visibility'=>'1','parent_news_id'=>'0'),array('news_id','desc'),1);
        if(!empty($tmpl['last_live_news'])){
            $tmpl['last_sub_live_news'] = $this->news_model->get_live_sub_news($tmpl['last_live_news'][0]['news_id']);
        }
        
        $this->load->view('page.home.php',$tmpl);
    }
}
