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
class News_types extends REST_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_types_table= 'news_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_table= 'news';
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';
    

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
        $this->lang->load('news_types');
        $this->load->model('news_types_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');
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
    public function list_news_types_datatable_post()
    {

        try {
            
            $news_types = $this->news_types_model->get_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($news_types as $news_type) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('news_types', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."news_types/view/".$news_type->rand_id."'>". $news_type->news_type_title . "</a>";
                }
                else{
                    $row[] = $news_type->news_type_title;
                }
                
                $row[] = $news_type->total_news;
                $row[] = $news_type->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news_type->date_created);
                
                $action = "";     
                if($this->permissions_model->check('news_types','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."news_types/edit/".$news_type->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news_types','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_news_type(".$news_type->news_type_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_types_model->count_all(),
                "recordsFiltered" => $this->news_types_model->count_filtered(),
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
    public function save_news_type_details_post()
    {

        try {
            if($this->input->post('news_type_id')){
                //chheck form validation
                $run_validation = 'save_news_types';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['news_type_id'] = $this->input->post('news_type_id');
                    
                    $topics = $this->input->post('topics');
                    
                    $data = array();
                    if($_FILES['news_type_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        // get file extension
                        $file_ext = pathinfo($_FILES["news_type_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_type_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_type_image'))
                        {
                            $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                            $this->response($return, 200);
                        }
                        else
                        {

                            $img_data = array('upload_data' => $this->upload->data());  
                            $data['thumbnail'] = $img_data['upload_data']['file_name'];
                        }
                    }
                    $data['rand_id'] = $this->input->post('news_type_url');
                    
                    //check rand id is unique
                    $r_id = $this->news_types_model->get_where($this->_news_types_table,array('rand_id'=>$this->input->post('news_type_url'),'news_type_id!='=>$this->input->post('news_type_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_type_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_type_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }   
                    
                    $data['news_type_title'] = $this->input->post('news_type_title');
                    $data['news_type_desc'] = $this->input->post('news_type_desc');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->news_types_model->update_news_type_details($this->_news_types_table,$data, $where);
                    if($res){
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_NEWS_TYPES;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of news type, News type ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for news type, News type ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_NEWS_TYPES;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the news type, News type ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news type, News type ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        $this->log_model->add('info', "News type updated successfully, News type ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('news_type_details_updated_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "News type could not be updated. News type ID(" . $where['news_type_id'] . ")");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_news_types';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    if($_FILES['news_type_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        // get file extension
                        $file_ext = pathinfo($_FILES["news_type_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_type_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_type_image'))
                        {
                            $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                            $this->response($return, 200);
                        }
                        else
                        {

                            $img_data = array('upload_data' => $this->upload->data());  
                            $data['thumbnail'] = $img_data['upload_data']['file_name'];
                        }
                    }
                    $topics = $this->input->post('topics');
                    $data['rand_id'] = $this->input->post('news_type_url');
                    //check rand id is unique
                    $r_id = $this->news_types_model->get_where($this->_news_types_table,array('rand_id'=>$this->input->post('news_type_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_type_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_type_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['news_type_title'] = $this->input->post('news_type_title');
                    $data['news_type_desc'] = $this->input->post('news_type_desc');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->news_types_model->save_news_type_details($this->_news_types_table,$data);
                    if($res){
                        $this->log_model->add('info', "New news type saved successfully, News type ID(".$res.")");
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_NEWS_TYPES;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the news type, News type ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news type, News type ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        $return = array('status'=>TRUE,'message'=>lang('new_news_type_details_saved_successfully'),'next'=>$rand_id);
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New news type could not be saved.");
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
    public function delete_news_type_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['news_type_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->news_types_model->update_news_type_details($this->_news_types_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "News type details deleted successfully. News type ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('news_type_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "News type details could not be deleted, News type ID(" . $where['news_type_id'] . ")");
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
    public function list_user_logs_datatable_post()
    {

        try {
            // check permission
//             $this->check_permission('blogs', 'read');
            $list = $this->users_model->get_user_logs_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($list as $log) {
                $no++;
                $row = array();
                $row[] = $log->operation;
                $row[] = $log->log_type;
                $row[] = date('M d, Y h:i A',$log->timestamp);


                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->users_model->count_user_logs_all(),
                "recordsFiltered" => $this->users_model->count_user_logs_filtered(),
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
    
    public function get_loggedin_user_module_statistics_post(){
        $return_stat = array(
            'blogs'=>0,
            'reminders'=>0,
            'albums'=>0,
            'bookings'=>0,
            'live_streamings'=>0,
            'videos'=>0,
            'events'=>0,
            'event_types'=>0,
            'tags'=>0,
            'packages'=>0,
            'package_types'=>0,
        );
        if($this->session->userdata('ds_user')){
            $return_stat['blogs'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'blogs');            
            $return_stat['reminders'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'reminders');            
            $return_stat['albums'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'albums');            
            $return_stat['bookings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'bookings');            
            $return_stat['live_streamings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'videos',VIDEO_TYPE_LIVE_STREAMING);            
            $return_stat['videos'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'videos',VIDEO_TYPE_VIDEO);
            $return_stat['events'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'events');            
            $return_stat['event_types'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'event_types');            
            $return_stat['tags'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'tags');            
            $return_stat['packages'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'packages');            
            $return_stat['package_types'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'package_types');            
        }
        $this->response($return_stat, 200);
    }
    
    
}
