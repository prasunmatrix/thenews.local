<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends MY_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_videos_table= 'videos';
    
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
        $this->lang->load('videos'); 
        $this->load->model('videos_model');        
    }
    public function index() {
        //check permissions
        $this->permissions_model->check_redirect('videos','index');
        
        $tmpl = array();
        $tmpl['page_title'] = lang('videos');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.videos.php',$tmpl);
    }
    public function add() {
        //check permissions
        $this->permissions_model->check_redirect('videos','add');
        
        $tmpl = array();
        $tmpl['page_title'] = lang('add_new_video');
        $tmpl['topics'] = $this->videos_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
        
        $this->load->view(DASHBOARD_DIR_NAME . 'page.add_video.php',$tmpl);
    }
    
    public function view($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('videos','view');
        
        if($url){
            $videos_details = $this->videos_model->get_where($this->_videos_table,array('rand_id'=>$url)); 
            if(!empty($videos_details)){
                $tmpl = array();
                $tmpl['video_details'] = $videos_details;
                $tmpl['page_title'] = $videos_details[0]['video_title'];
                $tmpl['topics'] = $this->videos_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['videos_topics'] = $this->videos_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_VIDEOS,'entity_id'=>$videos_details[0]['video_id']));
                
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_video.php',$tmpl);
            }
            else{
                 redirect(site_url().'videos/');
            }            
        }
        else{
            redirect(site_url().'videos/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('videos','edit');
        
        if($url){
            $videos_details = $this->videos_model->get_where($this->_videos_table,array('rand_id'=>$url)); 
            if(!empty($videos_details)){
                $tmpl = array();
                $tmpl['video_details'] = $videos_details;
                $tmpl['page_title'] = $videos_details[0]['video_title'];
                $tmpl['topics'] = $this->videos_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['video_topics'] = $this->videos_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_VIDEOS,'entity_id'=>$videos_details[0]['video_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_video.php',$tmpl);
            }
            else{
                 redirect(site_url().'videos/');
            }            
        }
        else{
            redirect(site_url().'videos/');
        }        
    }
}
