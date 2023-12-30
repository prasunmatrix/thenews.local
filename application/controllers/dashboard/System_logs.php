<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_logs extends MY_Controller {

    public function __construct() {
        parent::__construct();        
        $this->lang->load('systems');
        
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = lang('system_logs'); 
        $this->load->view(DASHBOARD_DIR_NAME . 'page.system_logs.php',$tmpl);
    }

}
