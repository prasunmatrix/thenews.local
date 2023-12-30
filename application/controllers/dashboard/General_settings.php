<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends MY_Controller {
         
    /**
     * @var string what table is used in the database for the Blogs
     */
    public $_general_config_table= 'general_config';
    
         
    /**
     * @var string what table is used in the database for the Blogs
     */
    public $_email_settings_table= 'email_settings';
    
         
    /**
     * @var string what table is used in the database for the Blogs
     */
    public $_languages_table = 'languages';
    

    public function __construct() {
        parent::__construct();
        $this->lang->load('general_settings');
        $this->load->model('general_settings_model');        
    }
    
    public function index()
    {
        $this->load->view(DASHBOARD_DIR_NAME.'page.general_settings.php');
    }
    
    public function client_details($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('client_details','edit');
        
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_client_details.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('client_details','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.client_details.php',$tmpl);
        }            
    }
    public function email_signature($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('email_signature','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_email_signature.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('email_signature','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.email_signature.php',$tmpl);
        }            
    }
    public function date_format($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('date_format','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_date_format.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('date_format','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.date_format.php',$tmpl);
        }            
    }
    public function website_logos($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('website_logos','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_website_logos.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('website_logos','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.website_logos.php',$tmpl);
        }            
    }
        
    public function social_links($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('social_links','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_social_links.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('social_links','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.social_links.php',$tmpl);
        }            
    }
    
    public function watermark_settings($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('watermark_settings','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_watermark_settings.php',$tmpl);
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('watermark_settings','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.watermark_settings.php',$tmpl);
        }            
    }
    public function email_settings(){
        //check permissions
        $this->permissions_model->check_redirect('email_settings','index');
        
        $tmpl = array();
        $tmpl['email_settings'] = $this->general_settings_model->get_where($this->_email_settings_table,array('deleted'=>'0'));
        $this->load->view(DASHBOARD_DIR_NAME.'page.email_settings.php',$tmpl);                    
    }
    public function languages(){
        //check permissions
        $this->permissions_model->check_redirect('languages','index');
            
        $tmpl = array();
        $tmpl['languages'] = $this->general_settings_model->get_where($this->_languages_table,array('deleted'=>'0'));
        $this->load->view(DASHBOARD_DIR_NAME.'page.languages.php',$tmpl);                    
    }
    
    public function google_adsense($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('google_adsense','edit');
        
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_google_adsense.php',$tmpl);                    
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('google_adsense','index');
        
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.google_adsense.php',$tmpl);                    
        }  
        
    }
    public function google_analytics($operation = false){
        if($operation=='edit'){
            //check permissions
            $this->permissions_model->check_redirect('google_analytics','edit');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.edit_google_analytics.php',$tmpl);                    
        }
        else{
            //check permissions
            $this->permissions_model->check_redirect('google_analytics','index');
            
            $tmpl = array();
            $tmpl['general_config'] = $this->general_settings_model->get_where($this->_general_config_table,array('deleted'=>'0'));
            $this->load->view(DASHBOARD_DIR_NAME.'page.google_analytics.php',$tmpl);                    
        } 
    }
}
