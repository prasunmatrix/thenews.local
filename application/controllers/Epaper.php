<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epaper extends CI_Controller {
    
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
    public $_epapers_table= 'epaper';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_trans_table= 'epaper_trans';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';    
    
    public $configs = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->model('log_model');
        
        $this->lang->load('header');
        $this->lang->load('epaper');
        $this->load->model('users_model');        
        $this->load->model('epaper_model');        
        
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
          redirect(site_url().'epaper/date/'.date('Y').'/'.date('m').'/'.date('d').'/1');
//        $tmpl = array();
//        $tmpl['page_title'] = lang('epapers');
//        $tmpl['epaper_details'] = $this->epaper_model->get_where($this->_epapers_table,array('epaper_date'=>date('Y').'-'.date('m').'-'.date('d'),'deleted'=>'0'));
//        if(!empty($tmpl['epaper_details'])){
//            $tmpl['epapers'] = $this->epaper_model->get_where_with_order($this->_epaper_trans_table,array('epaper_id'=>$tmpl['epaper_details'][0]['epaper_id']),array('page_num'=>'asc'));
//        }
//        $tmpl['configs'] = $this->configs;
//        $this->load->view('page.epaper.php',$tmpl);
    }
    
    public function date($y,$m,$d, $page_num)
    {
        if(isset($y)&&isset($m)&&isset($d)&&isset($page_num)){
            $tmpl = array();
            if($this->session->userdata('normal_user')){
                $loggedin_user_details = $this->epaper_model->get_where($this->_users_table, array('user_id'=>$this->session->userdata('normal_user')));
                $tmpl['subscription_end_date'] = $loggedin_user_details[0]['subscription_end_date'];
            }
            $tmpl['page_title'] = lang('epapers');
            $where = array('epaper_date'=>$y.'-'.$m.'-'.$d,'deleted'=>'0');
            $tmpl['epaper_details'] = $this->epaper_model->get_where($this->_epapers_table,$where);
            // echo "<pre>";
            // print_r($tmpl['epaper_details']); die;
            //echo $tmpl['epaper_details'][0]['epaper_id']; die;
            $tmpl['configs'] = $this->configs;
            $tmpl['d'] = $d;
            $tmpl['m'] = $m;
            $tmpl['y'] = $y;
            $tmpl['active_page'] = $page_num;
            if(!empty($tmpl['epaper_details'])){
                $tmpl['epapers'] = $this->epaper_model->get_where_with_order($this->_epaper_trans_table,array('epaper_id'=>$tmpl['epaper_details'][0]['epaper_id']),array('page_num'=>'asc'));
                // echo "<pre>";
                // print_r($tmpl['epapers']); die; 
                $this->load->view('page.epaper.php',$tmpl);
            }
            else{
                $this->load->view('page.epaper.php',$tmpl);
            }
                
        }
        else{
            redirect(site_url().'epaper/');
        }
    }
}
