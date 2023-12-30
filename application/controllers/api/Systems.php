<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * News types API
 *
 * @author		VR Patel
 * @copyright           Copyright (c) 2020, VR Patel.
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.vrpatel.in
 */

/**
 * @SWG\Resource(
 *     apiVersion="1.0",
 *     resourcePath="/Users",
 *     basePath="http://samachars.local/en/api",
 *     description="Operations on Users"
 * )
 */

require (APPPATH.'libraries/REST_Controller.php');

/**
 * Class News types
 *
 */
class Systems extends REST_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_system_logs_table= 'system_logs';
    
 
    public $configs = array();
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    /**
     * Constructor
     *
     * Load required resources.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('systems');
        $this->load->model('log_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');
        
        $general_config = $this->log_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
    }

    /**
     * @var string what table is used in the database for the users
     */
    
    /**
     * List GET
     *
     * Responds with information about all users available.
     *
     * @return string Data table supported JSON with users info
     */
    public function list_system_logs_datatable_post()
    {

        try {
            
            $newss = $this->log_model->get_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                
                $row[] = $news->log_id;
                $row[] = $news->operation;
                $row[] = $news->log_type;
                $row[] = $news->ip;
                $row[] = $news->os;
                $row[] = $news->url;
                $row[] = $news->browser;
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->timestamp);
                
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->log_model->count_all(),
                "recordsFiltered" => $this->log_model->count_filtered(),
                "data" => $data,
            );

            $this->response($result, 200);
        }
        catch (Exception $e)
        {
            // write to system log
            $this->log_model->add('error', $e->getMessage());

            $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
            $this->response($result, 500);
        }
    }    
    
    /**
     * List GET
     *
     * Responds with information about all users available.
     *
     * @return string Data table supported JSON with users info
     */
    public function list_subscribers_datatable_post()
    {

        try {
            
            $newss = $this->log_model->get_subscribers_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                
                $row[] = $news->sub_id;
                $row[] = $news->email;
                $row[] = date($this->configs['date_format'],$news->date_created);
                $row[] = "";
                
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->log_model->subscribers_count_all(),
                "recordsFiltered" => $this->log_model->subscribers_count_filtered(),
                "data" => $data,
            );

            $this->response($result, 200);
        }
        catch (Exception $e)
        {
            // write to system log
            $this->log_model->add('error', $e->getMessage());

            $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
            $this->response($result, 500);
        }
    }    
}
