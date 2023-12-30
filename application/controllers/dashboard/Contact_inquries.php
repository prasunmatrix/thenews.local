<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_inquries extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
    }
    public function index() {
        $this->load->view(DASHBOARD_DIR_NAME . 'page.contact_inquries.php');
    }

}
