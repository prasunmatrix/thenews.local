<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News_types extends MY_Controller {

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
        $this->lang->load('news_types'); 
        $this->load->model('news_types_model');
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = lang('news_types');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.news_types.php',$tmpl);
    }
    public function add() {
        //check permissions
        $this->permissions_model->check_redirect('news_types','add');
        
        $tmpl = array();
        $tmpl['page_title'] = "Add new news type";
        $tmpl['topics'] = $this->news_types_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
        $this->load->view(DASHBOARD_DIR_NAME . 'page.add_news_type.php',$tmpl);
    }
    
    public function view($url = FALSE)
    {   
        if($url){
            $news_type_details = $this->news_types_model->get_where($this->_news_types_table,array('rand_id'=>$url)); 
            if(!empty($news_type_details)){
                $tmpl = array();
                $tmpl['news_type_details'] = $news_type_details;
                $tmpl['page_title'] = $news_type_details[0]['news_type_title'];
                $tmpl['topics'] = $this->news_types_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_type_topics'] = $this->news_types_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS_TYPES,'entity_id'=>$news_type_details[0]['news_type_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_news_type.php',$tmpl);
            }
            else{
                 redirect(site_url().'news_types/');
            }            
        }
        else{
            redirect(site_url().'news_types/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        if($url){
            $news_type_details = $this->news_types_model->get_where($this->_news_types_table,array('rand_id'=>$url)); 
            if(!empty($news_type_details)){
                $tmpl = array();
                $tmpl['news_type_details'] = $news_type_details;
                $tmpl['page_title'] = $news_type_details[0]['news_type_title'];
                $tmpl['topics'] = $this->news_types_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['news_type_topics'] = $this->news_types_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_NEWS_TYPES,'entity_id'=>$news_type_details[0]['news_type_id']));                
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_news_type.php',$tmpl);
            }
            else{
                 redirect(site_url().'news_types/');
            }            
        }
        else{
            redirect(site_url().'news_types/');
        }        
    }
}
