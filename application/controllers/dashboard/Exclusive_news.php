<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exclusive_news extends MY_Controller {

    /**
     * @var string what table is used in the database for the users
     */
    public $_news_types_table= 'news_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_table= 'exclusive_news';
    
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
        //check permissions
        $this->permissions_model->check_redirect('exclusive_news','index');
        
        $tmpl = array();
        $tmpl['page_title'] = lang('exclusive_news');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.exclusive_news.php',$tmpl);
    }
    public function add($news_id = FALSE) {
        //check permissions
        $this->permissions_model->check_redirect('exclusive_news','add');
        
        $tmpl = array();
        if($news_id){
            $tmpl['news_id'] = $news_id;
        }
        $tmpl['page_title'] = lang('add_new_exclusive_news');
        $tmpl['exclusive_news'] = $this->news_model->get_where($this->_news_table,array('deleted'=>'0','visibility'=>'1','parent_news_id'=>'0'));
        $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
        
        $this->load->view(DASHBOARD_DIR_NAME . 'page.add_exclusive_news.php',$tmpl);
    }
    
    public function view($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('exclusive_news','view');
        
        if($url){
            $news_details = $this->news_model->get_where($this->_news_table,array('rand_id'=>$url)); 
            $news = $this->news_model->get_where_with_order($this->_news_table,array('visibility'=>'1','deleted'=>'0','parent_news_id'=>'0'),array('news_title'=>'asc')); 
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['news'] = $news;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_EXCLUSIVE_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_exclusive_news.php',$tmpl);
            }
            else{
                 redirect(site_url().'exclusive_news/');
            }            
        }
        else{
            redirect(site_url().'exclusive_news/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('exclusive_news','edit');
        
        if($url){
            $news_details = $this->news_model->get_where($this->_news_table,array('rand_id'=>$url)); 
            $news = $this->news_model->get_where_with_order($this->_news_table,array('visibility'=>'1','deleted'=>'0','parent_news_id'=>0),array('news_title'=>'asc')); 
            
            if(!empty($news_details)){
                $tmpl = array();
                $tmpl['news_details'] = $news_details;
                $tmpl['news'] = $news;
                $tmpl['page_title'] = $news_details[0]['news_title'];
                $tmpl['exclusive_news'] = $this->news_model->get_where($this->_news_table,array('deleted'=>'0','visibility'=>'1','parent_news_id'=>'0'));
                $tmpl['topics'] = $this->news_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_topics'] = $this->news_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_EXCLUSIVE_NEWS,'entity_id'=>$news_details[0]['news_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_exclusive_news.php',$tmpl);
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
