<?php

class Migrate extends MY_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->lang->load('migrations');
    }
    
    public function index()
    {
        $this->load->model('users_model');
        $this->load->library('migration');
        $tmpl = array();
        
        $tmpl['page_title'] = lang('title_migrate');
        $tmpl['migrations'] = $this->migration->find_migrations();
        $version = $this->migration->current();
        $tmpl['version'] = $version;
        
        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        }
        $tmpl['migration_return_html'] = $this->session->userdata('migration_return_html');
        $this->session->unset_userdata('migration_return_html');
        $this->load->view(DASHBOARD_DIR_NAME.'page.migrate.php', $tmpl);
    }
}
