<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

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
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';
    
    public function __construct() {
        parent::__construct();
        $this->lang->load('news'); 
        $this->load->model('news_model');        
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = "News";
        $this->load->view(DASHBOARD_DIR_NAME . 'page.news.php',$tmpl);
    }
    public function add() {
        //check permissions
        $this->permissions_model->check_redirect('news','add');
        
        $news_types = $this->news_model->get_where_with_order($this->_news_types_table,array('visibility'=>'1','deleted'=>'0'),array('news_type_title'=>'asc')); 
        
        $tmpl = array();
        $tmpl['page_title'] = "Add new news";
        $tmpl['news_types'] = $news_types;
        $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
        
        $this->load->view(DASHBOARD_DIR_NAME . 'page.add_news.php',$tmpl);
    }
    
    public function view($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('news','view');
        
        if($url){
            $news_details = $this->news_model->get_where($this->_news_table,array('rand_id'=>$url)); 
            $news_types = $this->news_model->get_where_with_order($this->_news_types_table,array('visibility'=>'1','deleted'=>'0'),array('news_type_title'=>'asc')); 
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['news_types'] = $news_types;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_news.php',$tmpl);
            }
            else{
                 redirect(site_url().'news/');
            }            
        }
        else{
            redirect(site_url().'news/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('news','edit');
        
        if($url){
            $news_details = $this->news_model->get_where($this->_news_table,array('rand_id'=>$url)); 
            $news_types = $this->news_model->get_where($this->_news_types_table,array('visibility'=>'1','deleted'=>'0')); 
            
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['news_types'] = $news_types;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_news.php',$tmpl);
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
