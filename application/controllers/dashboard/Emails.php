<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emails extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
    }
    public function index() {
        $this->load->view(DASHBOARD_DIR_NAME . 'page.emails.php');
    }

}
