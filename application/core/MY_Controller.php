<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_Controller extends CI_Controller {

    /**
     * $ajaxRequest : this is the variable which contains the requested page is via ajax call or not. by default it is false and will be set as false and will be set as true in constructor after validating the request type.
     *
     */
    public $ajaxRequest = false;
    public $template = NULL;
    private $_whitelisted = array(
        'admin_login_index',
        'admin_login_forgot_password',
        'login_index',
        'login_forgot_password',
        'login_register',
        'login_impersonate',
    );
    
    public $configs = array();
    
    public $user_data = array();
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    public function __construct() {
        parent::__construct();
        /**
         * validating the request type is ajax or not and setting up the $ajaxRequest variable as true/false.
         *
         */
        $this->lang->load('header');
        $requestType = $this->input->server('HTTP_X_REQUESTED_WITH');
        $this->ajaxRequest = strtolower($requestType) == 'xmlhttprequest';
        $this->load->model('users_model');        
        $this->load->model('log_model');
        $this->load->model('permissions_model');
        $this->load->model('localization_model');
        $this->load->model('email_notification_model');
        
        $general_config = $this->users_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        $this->user_data = $this->users_model->get_where($this->_users_table,array('deleted'=>'0','user_id'=>$this->session->userdata('ds_user')));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
        date_default_timezone_set($this->configs['timezone']);
    }

    public function _dremap($method) {
        $this->load->library('session');
        $this->load->helper('url');
        if ($this->session->userdata('ds_user') == '') {
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
                header('X-CI-LoggedOut: 1');
            } else {
                redirect('admin_login');
            }
            return (false);
        }

        $params = array_slice($this->uri->segment_array(), 2);
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function _remap($method, $params = array()) {
        $controller = $this->router->fetch_class();
        $action = $this->router->fetch_method();

        $controller_action = strtolower($controller . '_' . $action);

        $redirectToLogin = false;

        if (in_array($controller_action, $this->_whitelisted)) {
            $redirectToLogin = true;
        }

        if (($method == 'login' && is_array($params) && count($params) == 1 && $params[0] == 'redirectForcefully') ||
                ($method == 'validate' && is_array($params) && count($params) == 1 && $params[0] == 'redirectForcefully')
        ) {
            $redirectToLogin = true;
        }


        if ($redirectToLogin == false) {
            if ($this->session->userdata('ds_user') == '') {
                $this->session->set_userdata('next_url', current_url());
                redirect('login');
            }
        }

        $this->load->library('session');

        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }
}
