<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings API
 *
 * @author		VR Patel
 * @copyright           Copyright (c) 2020, VR Patel.
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.thefilmygyan.com/
 */

/**
 * @SWG\Resource(
 *     apiVersion="1.0",
 *     resourcePath="/Users",
 *     basePath="http://www.thefilmygyan.com/en/api",
 *     description="Operations on Users"
 * )
 */

require (APPPATH.'libraries/REST_Controller.php');

/**
 * Class Settings
 *
 */
class Settings extends REST_Controller {
    
    /**
     * @var string what table is used in the database for the topics
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_topic_entities_table= 'topic_entities_trans';

    /**
     * @var string what table is used in the database for the topics
     */
    public $_menu_items_table= 'menu_items';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_menu_sub_items_table= 'menu_sub_items';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_general_config_table = 'general_config';

    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_terms_and_conditions_table = 'terms_and_conditions';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_privacy_and_policy_table = 'privacy_and_policy';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_about_us_table = 'about_us';
    
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
        $this->lang->load('settings');
        $this->lang->load('header');
        $this->load->model('settings_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');
        $config = array();
        $config['image_library'] = 'gd2';
        $this->load->library('image_lib',$config);
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
    public function list_menu_items_datatable_post()
    {

        try {
            
            $items = $this->settings_model->get_menu_items_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($items as $item) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('menu_items','view')){
                    $row[] = "<a href='". site_url().DASHBOARD_DIR_NAME."settings/menu_items/view/".$item->rand_id."'>".$item->item_title."</a>";
                }
                else{
                    $row[] = $item->item_title;
                }
                $row[] = $item->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$item->date_created);
                
                $action = "";     
                if($this->permissions_model->check('menu_items','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."settings/menu_items/edit/".$item->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('menu_items','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_menu_item(".$item->item_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->settings_model->menu_items_count_all(),
                "recordsFiltered" => $this->settings_model->menu_items_count_filtered(),
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
    public function list_educational_institutes_datatable_post()
    {

        try {
            
            $items = $this->settings_model->get_educational_institutes_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($items as $item) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('educational_institutes','view')){
                    $row[] = "<a href='". site_url().DASHBOARD_DIR_NAME."settings/educational_institutes/view/".$item->inst_rand_id."'>".$item->inst_name."</a>";
                }
                else{
                    $row[] = $item->inst_name;
                }
                $row[] = $item->created_by;
                $row[] = $item->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$item->date_created);
                
                $action = "";     
                if($this->permissions_model->check('educational_institutes','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."settings/educational_institutes/edit/".$item->inst_rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('educational_institutes','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_educational_institute(".$item->inst_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->settings_model->educational_institutes_count_all(),
                "recordsFiltered" => $this->settings_model->educational_institutes_count_filtered(),
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
    public function list_menu_sub_items_datatable_post()
    {

        try {
            $parent_item_id = $this->input->post('item_id');
            $items = $this->settings_model->get_menu_sub_items_datatables($parent_item_id);
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($items as $item) {
                $no++;
                $row = array();
                $row[] = $no;
                
                $row[] = $item->sub_item_title;
                
                $row[] = $item->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$item->date_created);
                
                $action = "";     
                if($this->permissions_model->check('menu_sub_items','edit')){
                    $action .= "<a href='#' onclick='edit_sub_menu_details(".$item->sub_item_id.")'><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('menu_sub_items','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_menu_sub_item(".$item->sub_item_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->settings_model->menu_sub_items_count_all($parent_item_id),
                "recordsFiltered" => $this->settings_model->menu_sub_items_count_filtered($parent_item_id),
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
    public function get_sub_item_details_post()
    {

        try {
            $sub_item_id = $this->input->post('id');
            
            $item_details = $this->settings_model->get_where($this->_menu_sub_items_table,array('sub_item_id'=>$sub_item_id));
            
            $this->response($item_details, 200);
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
    public function list_topics_datatable_post()
    {

        try {
            
            $topics = $this->settings_model->get_topics_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($topics as $topic) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = "<span class='".$topic->class_name." btn-xs' style='line-height:1;'>".$topic->topic_name."</span>";
                $row[] = $topic->used_times;
                $row[] = $topic->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$topic->date_created);
                
                $action = "";     
                if($this->permissions_model->check('topics','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."settings/topics/edit/".$topic->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('topics','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_topic(".$topic->topic_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->settings_model->count_all(),
                "recordsFiltered" => $this->settings_model->count_filtered(),
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
    public function save_topic_details_post()
    {

        try {
            if($this->input->post('topic_id')){
                //chheck form validation
                $run_validation = 'save_topic_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['topic_id'] = $this->input->post('topic_id');
                    
                    $data = array();
                    $data['rand_id'] = $this->input->post('topic_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_topics_table,array('rand_id'=>$this->input->post('topic_url'),'topic_id!='=>$this->input->post('topic_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('topic_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('topic_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['topic_name'] = $this->input->post('topic_name');
                    $data['lang'] = $this->uri->segment(1);
                    $data['class_name'] = $this->input->post('class_name');
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->update_topic_details($this->_topics_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "Topic details updated successfully, Topic ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('topic_details_updated_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "Topic details could not be updated.");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_topic_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    $data['rand_id'] = $this->input->post('topic_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_topics_table,array('rand_id'=>$this->input->post('topic_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('topic_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('topic_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['topic_name'] = $this->input->post('topic_name');
                    $data['lang'] = $this->uri->segment(1);
                    $data['class_name'] = $this->input->post('class_name');
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->save_topic_details($this->_topics_table,$data);
                    if($res){
                        $this->log_model->add('info', "New topic details saved successfully, Topic ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('new_topic_details_saved_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New topic details could not be saved.");
                    }
                    $this->response($return, 200);
                }
            }
                
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
    public function save_terms_and_conditions_post()
    {

        try {                
            $where = array();
            $where['id'] = "1";
            
            $data = array();
            $data['terms_and_conditions'] = $this->input->post('terms');
            
            $data['seo_title'] = $this->input->post('seo_title');
            $data['seo_keywords'] = $this->input->post('seo_keyword');
            $data['seo_desc'] = $this->input->post('seo_desc');

            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');

            $res = $this->settings_model->update_terms_and_conditions_details($this->_terms_and_conditions_table,$data,$where);
            if($res){
                $this->log_model->add('info', "Terms and conditions updated successfully.");
                $return = array('status'=>TRUE,'message'=>lang('terms_and_conditions_updated_successfully'));

            }
            else{
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->log_model->add('error', "Terms and conditions could not be updated.");
            }
            $this->response($return, 200);   
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
    public function save_privacy_and_policy_post()
    {

        try {                
            $where = array();
            $where['id'] = "1";
            
            $data = array();
            $data['privacy_and_policy'] = $this->input->post('terms');
            
            $data['seo_title'] = $this->input->post('seo_title');
            $data['seo_keywords'] = $this->input->post('seo_keyword');
            $data['seo_desc'] = $this->input->post('seo_desc');

            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');

            $res = $this->settings_model->update_terms_and_conditions_details($this->_privacy_and_policy_table,$data,$where);
            if($res){
                $this->log_model->add('info', "Privacy and policy updated successfully.");
                $return = array('status'=>TRUE,'message'=>lang('privacy_and_policy_updated_successfully'));

            }
            else{
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->log_model->add('error', "Privacy and policy could not be updated.");
            }
            $this->response($return, 200);   
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
    public function save_about_us_post()
    {

        try {                
            $where = array();
            $where['id'] = "1";
            
            $data = array();
            $data['about_us'] = $this->input->post('terms');
            
            $data['seo_title'] = $this->input->post('seo_title');
            $data['seo_keywords'] = $this->input->post('seo_keyword');
            $data['seo_desc'] = $this->input->post('seo_desc');

            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');

            $res = $this->settings_model->update_terms_and_conditions_details($this->_about_us_table,$data,$where);
            if($res){
                $this->log_model->add('info', "About us updated successfully.");
                $return = array('status'=>TRUE,'message'=>lang('about_us_updated_successfully'));

            }
            else{
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->log_model->add('error', "About us could not be updated.");
            }
            $this->response($return, 200);   
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
    public function save_menu_item_details_post()
    {

        try {
            if($this->input->post('item_id')){
                //chheck form validation
                $run_validation = 'save_menu_item_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['item_id'] = $this->input->post('item_id');
                    
                    $data = array();
                    $data['rand_id'] = $this->input->post('item_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_menu_items_table,array('rand_id'=>$this->input->post('item_url'),'item_id!='=>$this->input->post('item_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('item_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('item_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['item_title'] = $this->input->post('item_title');
                    
                    $data['item_href'] = $this->input->post('item_href');
                    $data['item_icon'] = $this->input->post('item_icon');
                    $data['lang'] = $this->uri->segment(1);
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->update_menu_item_details($this->_menu_items_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "Menu item details updated successfully, Menu item ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('menu_item_details_updated_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "Menu item details could not be updated.");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_menu_item_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    $data['rand_id'] = $this->input->post('item_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_menu_items_table,array('rand_id'=>$this->input->post('item_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('item_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('item_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['item_title'] = $this->input->post('item_title');
                    
                    $data['item_href'] = $this->input->post('item_href');
                    $data['item_icon'] = $this->input->post('item_icon');
                    $data['lang'] = $this->uri->segment(1);
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->save_menu_item_details($this->_menu_items_table,$data);
                    if($res){
                        $this->log_model->add('info', "New menu item details saved successfully, Menu item ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('new_menu_item_details_saved_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New menu item details could not be saved.");
                    }
                    $this->response($return, 200);
                }
            }
                
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
    public function save_menu_sub_item_details_post()
    {

        try {
            if($this->input->post('sub_item_id')){
                //chheck form validation
                $run_validation = 'save_menu_sub_item_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['sub_item_id'] = $this->input->post('sub_item_id');
                    
                    $data = array();
                    $data['sub_rand_id'] = $this->input->post('sub_item_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_menu_sub_items_table,array('sub_rand_id'=>$this->input->post('sub_item_url'),'sub_item_id!='=>$this->input->post('sub_item_id')));
                    if(empty($r_id)){
                        $data['sub_rand_id'] = $this->input->post('sub_item_url');
                        $rand_id = $data['sub_rand_id'];
                    }
                    else{
                        $data['sub_rand_id'] = $this->input->post('sub_item_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['sub_rand_id'];
                    }  
                    
                    $data['parent_item_id'] = $this->input->post('parent_item_id');
                    $data['sub_item_title'] = $this->input->post('sub_item_title');
                    
                    $data['sub_item_href'] = $this->input->post('sub_item_href');
                    $data['sub_item_icon'] = $this->input->post('sub_item_icon');
                    $data['sub_item_lang'] = $this->uri->segment(1);
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->update_menu_sub_item_details($this->_menu_sub_items_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "Menu sub item details updated successfully, Menu sub item ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('menu_sub_item_details_updated_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New menu sub item details could not be saved.");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_menu_sub_item_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    $data['sub_rand_id'] = $this->input->post('sub_item_url');
                    //check rand id is unique
                    $r_id = $this->settings_model->get_where($this->_menu_sub_items_table,array('sub_rand_id'=>$this->input->post('sub_item_url')));
                    if(empty($r_id)){
                        $data['sub_rand_id'] = $this->input->post('sub_item_url');
                        $rand_id = $data['sub_rand_id'];
                    }
                    else{
                        $data['sub_rand_id'] = $this->input->post('sub_item_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['sub_rand_id'];
                    }  
                    
                    $data['parent_item_id'] = $this->input->post('parent_item_id');
                    $data['sub_item_title'] = $this->input->post('sub_item_title');
                    
                    $data['sub_item_href'] = $this->input->post('sub_item_href');
                    $data['sub_item_icon'] = $this->input->post('sub_item_icon');
                    $data['sub_item_lang'] = $this->uri->segment(1);
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->settings_model->save_menu_sub_item_details($this->_menu_sub_items_table,$data);
                    if($res){
                        $this->log_model->add('info', "New menu sub item details saved successfully, Menu sub item ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('new_menu_sub_item_details_saved_successfully'));

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New menu sub item details could not be saved.");
                    }
                    $this->response($return, 200);
                }
            }
                
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
    public function delete_topic_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['topic_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->settings_model->update_topic_details($this->_topics_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Topic details deleted successfully. Topic ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('topic_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Topic details could not be deleted, Topic ID(" . $where['topic_id'] . ")");
                }
                $this->response($return, 200);
            } 
            else {              
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->response($return, 400);
            }
            
                
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
    public function delete_menu_item_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['item_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->settings_model->update_menu_item_details($this->_menu_items_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Menu item details deleted successfully. Menu item ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('menu_item_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Menu item details could not be deleted, Menu item ID(" . $where['item_id'] . ")");
                }
                $this->response($return, 200);
            } 
            else {              
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->response($return, 400);
            }
            
                
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
    public function delete_menu_sub_item_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['sub_item_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->settings_model->update_menu_sub_item_details($this->_menu_sub_items_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Menu sub item details deleted successfully. Menu sub item ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('menu_sub_item_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Menu sub item details could not be deleted, Menu sub item ID(" . $where['item_id'] . ")");
                }
                $this->response($return, 200);
            } 
            else {              
                $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                $this->response($return, 400);
            }
            
                
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
    public function forgot_password_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'forgot_password';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['email'] = $this->input->post('s_email');

                $user_details = $this->users_model->get_where($this->_users_table, $where);

                if(!empty($user_details)){
                    $email_response = $this->email_notification_model->send_reset_password_email($user_details[0]['user_id']);
                    if($email_response){
                        $return = array('status'=> TRUE, 'message' => lang('we_have_sent_you_an_email_with_a_link_to_initiate_a_password_reset_procedure'));
                    }
                    else{
                        $return = array('status'=> TRUE, 'message' => lang('msg_something_went_wrong'));
                    }
                    $this->response($return, 200);   
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('the_provided_credentials_have_not_been_found_in_our_database'));
                    $this->response($return, 200);   
                }
                
            }
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
    public function get_movies_list_for_award_post()
    {

        try {
            
            $movies_list = $this->settings_model->get_where_with_order($this->_movies_table, array(),array('movie_title','asc'));

            if(!empty($movies_list)){
                
                $html = "";
                $html .= "<select class='form-control form-control-sm mt-1' name='award_entity_id'>";
                foreach($movies_list as $movie){
                    $html .= "<option value='".$movie['movie_id']."'>" . $movie['movie_title'] . "</option>";
                }
                $html .= "</select>";
                
                $return = array('status'=>TRUE,'output'=>$html);
                
                $this->response($return, 200);   
            }
            else{
                
                $return = array('status'=>FALSE,'message'=>lang('no_movie_found'));
                $this->response($return, 200);   
            }
                
            
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
    public function get_web_series_list_for_award_post()
    {

        try {
            
            $movies_list = $this->settings_model->get_where_with_order($this->_web_series_table, array(),array('webseries_title','asc'));

            if(!empty($movies_list)){
                
                $html = "";
                $html .= "<select class='form-control form-control-sm mt-1' name='award_entity_id'>";
                foreach($movies_list as $movie){
                    $html .= "<option value='".$movie['movie_id']."'>" . $movie['movie_title'] . "</option>";
                }
                $html .= "</select>";
                
                $return = array('status'=>TRUE,'output'=>$html);
                
                $this->response($return, 200);   
            }
            else{
                
                $return = array('status'=>FALSE,'message'=>lang('no_web_series_found'));
                $this->response($return, 200);   
            }
                
            
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
    public function get_songs_list_for_award_post()
    {

        try {
            
            $movies_list = $this->settings_model->get_where_with_order($this->_songs_table, array(),array('song_title','asc'));

            if(!empty($movies_list)){
                
                $html = "";
                $html .= "<select class='form-control form-control-sm mt-1' name='award_entity_id'>";
                foreach($movies_list as $movie){
                    $html .= "<option value='".$movie['movie_id']."'>" . $movie['movie_title'] . "</option>";
                }
                $html .= "</select>";
                
                $return = array('status'=>TRUE,'output'=>$html);
                
                $this->response($return, 200);   
            }
            else{
                
                $return = array('status'=>FALSE,'message'=>lang('no_song_found'));
                $this->response($return, 200);   
            }
                
            
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
