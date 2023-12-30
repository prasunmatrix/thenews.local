<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('systems');
    }
    public function index() {
        $tmpl = array();
        $tmpl['page_title'] = lang('newsletter');
        $this->load->view(DASHBOARD_DIR_NAME . 'page.subscribers.php', $tmpl);
    }

}
