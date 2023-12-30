<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {
    
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
    public $_videos_table= 'videos';
    
    
    public $configs = array();
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_bookmark_table= 'bookmarks';
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
        $this->lang->load('videos');
        $this->load->model('users_model');        
        $this->load->model('videos_model');        
        
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
        $tmpl['page_title'] = lang('videos');
        $tmpl['videos'] = $this->videos_model->get_videos_posts(10);
        $tmpl['configs'] = $this->configs;
        $this->load->view('page.videos.php',$tmpl);
    }
    
    public function view($url)
    {
        if($url){
            $videos_details = $this->videos_model->get_post_details($url); 
            if(!empty($videos_details)){
                $tmpl = array();
                $tmpl['video_details'] = $videos_details;
                $tmpl['page_title'] = $videos_details[0]['video_title'];
                $tmpl['topics'] = $this->videos_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['videos_topics'] = $this->videos_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_VIDEOS,'entity_id'=>$videos_details[0]['video_id']));
                $tmpl['configs'] = $this->configs;
                if($this->session->userdata('normal_user')){
                    $bookmark = $this->videos_model->get_where($this->_bookmark_table,array("user_id"=>$this->session->userdata('normal_user'),"entity"=>"video","entity_id"=>$videos_details[0]['video_id']));
                    if(isset($bookmark)){
                        if(!empty($bookmark)){
                            $tmpl['bookmark'] = TRUE;
                        }
                    }
                }
                $this->load->view('page.view_video.php',$tmpl);
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
