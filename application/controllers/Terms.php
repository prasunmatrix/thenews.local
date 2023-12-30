<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends CI_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_about_us_table= 'terms_and_conditions';
    
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
        $tmpl['page_title'] = lang('terms_and_conditions');
        $this->load->view('page.terms.php',$tmpl);
    }
}
