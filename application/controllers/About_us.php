<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_about_us_table= 'about_us';
    
    public function __construct() {
    
        parent::__construct();
        $this->lang->load('header');
        $this->load->helper('url');
        $this->load->model('log_model');
        $this->load->model('users_model');
    }
    
    public function index()
    {
        $tmpl = array();
        $tmpl['about_us_details'] = $this->log_model->get_where($this->_about_us_table,array());
        $tmpl['page_title'] = lang('about_us');
        $this->load->view('page.about_us.php',$tmpl);
    }
}
