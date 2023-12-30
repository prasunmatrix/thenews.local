<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Epaper extends MY_Controller {

    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_types_table= 'epaper_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_table= 'epaper';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_trans_table= 'epaper_trans';

    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';
    
    public function __construct() {
        parent::__construct();
        $this->lang->load('epaper'); 
        $this->load->model('epaper_model');        
    }
    public function index() {
        //check permissions
        $this->permissions_model->check_redirect('epaper','index');
        
        $tmpl = array();
        $tmpl['page_title'] = lang('epaper');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.epaper.php',$tmpl);
    }
    public function add($epaper_id = FALSE) {
        //check permissions
        $this->permissions_model->check_redirect('epaper','add');
        
        $tmpl = array();
        if($epaper_id){
            $tmpl['epaper_id'] = $epaper_id;
        }
        $tmpl['page_title'] = lang('add_new_epaper');
        $tmpl['topics'] = $this->epaper_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
        
        $this->load->view(DASHBOARD_DIR_NAME . 'page.add_epaper.php',$tmpl);
    }
    
    public function view($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('epaper','view');
        
        if($url){
            $epaper_details = $this->epaper_model->get_where($this->_epaper_table,array('rand_id'=>$url)); 
            $epapers = $this->epaper_model->get_where_with_order($this->_epaper_trans_table,array('epaper_id'=>$epaper_details[0]['epaper_id']),array('page_num'=>'asc')); 
            if(!empty($epaper_details)){
                $tmpl = array();
                $tmpl['epapers'] = $epapers;
                $tmpl['epaper_details'] = $epaper_details;
                $tmpl['page_title'] = $epaper_details[0]['epaper_title'];
                $tmpl['topics'] = $this->epaper_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['epaper_topics'] = $this->epaper_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_EPAPER,'entity_id'=>$epaper_details[0]['epaper_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.view_epaper.php',$tmpl);
            }
            else{
                 redirect(site_url().'epaper/');
            }            
        }
        else{
            redirect(site_url().'epaper/');
        }        
    }
    
    public function edit($url = FALSE)
    {   
        //check permissions
        $this->permissions_model->check_redirect('epaper','edit');
        
        if($url){
            $epaper_details = $this->epaper_model->get_where($this->_epaper_table,array('rand_id'=>$url)); 
            $epapers = $this->epaper_model->get_where_with_order($this->_epaper_trans_table,array('epaper_id'=>$epaper_details[0]['epaper_id']),array('page_num'=>'asc')); 
            
            if(!empty($epaper_details)){
                $tmpl = array();
                $tmpl['epaper_details'] = $epaper_details;
                $tmpl['epapers'] = $epapers;
                $tmpl['page_title'] = $epaper_details[0]['epaper_title'];
                $tmpl['topics'] = $this->epaper_model->get_where($this->_topics_table,array('deleted'=>'0','visibility'=>'1'));
                $tmpl['epaper_topics'] = $this->epaper_model->get_where($this->_topic_entities_trans_table,array('deleted'=>'0','entity'=>TOPICS_ENTITY_EPAPER,'entity_id'=>$epaper_details[0]['epaper_id']));
                $this->load->view(DASHBOARD_DIR_NAME.'page.add_epaper.php',$tmpl);
            }
            else{
                 redirect(site_url().'epaper/');
            }            
        }
        else{
            redirect(site_url().'epaper/');
        }        
    }
}
