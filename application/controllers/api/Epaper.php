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
class Epaper extends REST_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_table= 'epaper';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_trans_table= 'epaper_trans';
        
    /**
     * @var string what table is used in the database for the users
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';
    
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
        $this->lang->load('epaper'); 
        $this->load->model('epaper_model');
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
    public function list_epaper_datatable_post()
    {

        try {
            
            $epaper = $this->epaper_model->get_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($epaper as $epaper_type) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('epaper', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."epaper/view/".$epaper_type->rand_id."'>". $epaper_type->epaper_title . "</a>";
                }
                else{
                    $row[] = $epaper_type->epaper_title;
                }
                
                $row[] = $epaper_type->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$epaper_type->date_created);
                
                $action = "";     
                if($this->permissions_model->check('epaper','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."epaper/edit/".$epaper_type->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('epaper','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_epaper(".$epaper_type->epaper_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->epaper_model->count_all(),
                "recordsFiltered" => $this->epaper_model->count_filtered(),
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
    public function save_epaper_details_post()
    {
        
        $config = array();
        $config['image_library'] = 'gd2';
        $this->load->library('image_lib',$config);
        
        try {
            
            if($this->input->post('epaper_id')){
            
                //chheck form validation
                $run_validation = 'save_epaper_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {
                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['epaper_id'] = $this->input->post('epaper_id');
                    
                    $topics = $this->input->post('topics');
                    
                    $data = array();
                    
                    //                    $data['rand_id'] = $this->input->post('epaper_url');
                    //                    
                    //                    //check rand id is unique
                    //                    $r_id = $this->epaper_model->get_where($this->_epaper_table,array('rand_id'=>$this->input->post('epaper_url'),'epaper_id!='=>$this->input->post('epaper_id')));
                    //                    if(empty($r_id)){
                    //                        $data['rand_id'] = $this->input->post('epaper_url');
                    //                        $rand_id = $data['rand_id'];
                    //                    }
                    //                    else{
                    //                        $data['rand_id'] = $this->input->post('epaper_url'). '-' . random_string('alnum',6);
                    //                        $rand_id = $data['rand_id'];
                    //                    }   
                    
                    $date = explode("/", $this->input->post('epaper_date'));
                    $date = $date[2].'-'.$date[1].'-'.$date[0];

                    $data['epaper_title'] = $this->input->post('epaper_title');
                    $data['epaper_date'] = $date;
                    $data['rand_id'] = $rand_id = random_string('alnum',6);

                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->epaper_model->update_epaper_details($this->_epaper_table,$data, $where);
                    if($res){
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_EPAPER;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of epaper, ePaper ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for epaper, ePaper ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_EPAPER;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the epaper, ePaper ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the epaper, ePaper ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        $this->log_model->add('info', "ePaper updated successfully, ePaper ID(".$res.")");
                        
                        $pages = $this->input->post('epaper_pages_counter');
                        $epaper_pages_counter_start = $this->input->post('epaper_pages_counter_start');
                        
                        for($i=$epaper_pages_counter_start;$i<=$pages;$i++){
                            if($_FILES['epaper_image_'.$i]['name']!=""){

                                $data = array();
                                $data['epaper_id'] = $res;
                                $data['page_num'] = $i;
                                if($_FILES['epaper_image_' . $i]['type']=="application/pdf"){
                                    $config['upload_path']          = './public_html/upload/pdfs/';
                                }
                                else{
                                    $config['upload_path']          = './public_html/upload/images/';
                                }
                                $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|pdf';
                                $config['max_size']             = 25000;

                                $image_sizes = array(
                                    'small' => array(500, 500),
                                );


                                // get file extension
                                $file_ext = pathinfo($_FILES["epaper_image_".$i]["name"], PATHINFO_EXTENSION);

                                // change file name
                                $_FILES['epaper_image_'.$i]['name'] = sha1(microtime()) . "." .$file_ext;

                                //load library
                                $this->load->library('upload', $config);

                                if ( ! $this->upload->do_upload('epaper_image_'.$i))
                                {
                                    $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                                    $this->response($return, 200);
                                }
                                else
                                {

                                    $img_data = array('upload_data' => $this->upload->data());                            
                                    $data['thumbnail'] = $img_data['upload_data']['file_name'];
                                    $uploaded_image = $img_data['upload_data']['file_name'];

                                    if($_FILES['epaper_image_' . $i]['type']=="application/pdf"){
                                        $full_path = './public_html/upload/pdfs/'.$uploaded_image;
                                        $this->s3_bucket_upload($full_path, $uploaded_image,'pdfs');
                                    }
                                    else{
                                        $full_path = './public_html/upload/images/'.$uploaded_image;
                                        $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                                    }
                                    

                                    $small_image_link = "";
                                    $large_image_link = "";

                                    if($_FILES['epaper_image_' . $i]['type']!="application/pdf"){
                                        //creating thumbnails
                                        foreach ($image_sizes as $key=>$resize) {
                                            if($key=='small'){
                                                $large_thumb_img_name = sha1(microtime()) . "." . $file_ext;
                                                $small_image_link = $large_thumb_img_name;
                                                $data['s_thumbnail'] = $large_thumb_img_name;
                                            }

                                            $large_config = array(
                                                'source_image' => './public_html/upload/images/'.$uploaded_image,
                                                'new_image' => './public_html/upload/images/'.$large_thumb_img_name,
                                                'maintain_ration' => true,
                                                'width' => $resize[0],
                                                'height' => $resize[1]
                                            );
                                            $this->image_lib->initialize($large_config);
                                            if (!$this->image_lib->resize()) {
                                                echo $this->image_lib->display_errors();
                                            }
                                            $full_path = './public_html/upload/images/'.$large_thumb_img_name;
                                            $res_s3_upload = $this->s3_bucket_upload($full_path, $large_thumb_img_name,'images');
                                            if($res_s3_upload['status']){
                                                $this->unlink_file($large_thumb_img_name,'images');
                                            }
                                        }
                                        if($res_s3_upload['status']){
                                            $this->unlink_file($uploaded_image,'images');
                                        }
                                    }

                                    $r = $this->epaper_model->save_epaper_trans_details($this->_epaper_trans_table,$data);
                                    if($r){
                                        $this->log_model->add('info', "ePaper page number " . $i . " successfully uploaded.");
                                    }
                                    else{
                                        $this->log_model->add('error', "ePaper page number " . $i . " could not be uploaded.");
                                    }
                                }
                            }
                        }
                        
                        $return = array('status'=>TRUE,'message'=>lang('epaper_details_updated_successfully'),'next'=>$rand_id);
                        $this->response($return, 200);
                    }
                    else{
                        
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "ePapercould not be updated. ePaper ID(" . $where['epaper_id'] . ")");
                        $this->response($return, 200);
                    }
                    
                }
            }
            else{
                
                //chheck form validation
                $run_validation = 'save_epaper_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    if($_FILES['epaper_image_1']['name']==""){
                        $return = array('status' => false, 'message' => lang('please_upload_at_leat_one_page_for_the_epaper'));
                        $this->response($return, 200);
                    }
                    else{
                        $data = array();
                        
                        $topics = $this->input->post('topics');
                        //                        $data['rand_id'] = $this->input->post('epaper_url');
                        //                        //check rand id is unique
                        //                        $r_id = $this->epaper_model->get_where($this->_epaper_table,array('rand_id'=>$this->input->post('epaper_url')));
                        //                        if(empty($r_id)){
                        //                            $data['rand_id'] = $this->input->post('epaper_url');
                        //                            $rand_id = $data['rand_id'];
                        //                        }
                        //                        else{
                        //                            $data['rand_id'] = $this->input->post('epaper_url'). '-' . random_string('alnum',6);
                        //                            $rand_id = $data['rand_id'];
                        //                        }  

                        $date = explode("/", $this->input->post('epaper_date'));
                        $date = $date[2].'-'.$date[1].'-'.$date[0];
                        
                        $data['epaper_title'] = $this->input->post('epaper_title');
                        $data['epaper_date'] = $date;
                        $data['rand_id'] = $rand_id = random_string('alnum',6);
                        
                        $data['lang'] = $this->uri->segment(1);
                        $data['seo_title'] = $this->input->post('seo_title');
                        $data['seo_keywords'] = $this->input->post('seo_keyword');
                        $data['seo_desc'] = $this->input->post('seo_desc');

                        $data['date_created'] = now();
                        $data['user_created'] = $this->session->userdata('ds_user');


                        $res = $this->epaper_model->save_epaper_details($this->_epaper_table,$data);
                        if($res){
                            $this->log_model->add('info', "New ePaper saved successfully, ePaper ID(".$res.")");
                            if(!empty($topics)){
                                foreach($topics as $topic){
                                    $data = array();
                                    $data['entity'] = TOPICS_ENTITY_EPAPER;
                                    $data['entity_id'] = $res;
                                    $data['topic_id'] = $topic;

                                    $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                    if($r){
                                        $this->log_model->add('info', "New topic added successfully to the ePaper, ePaper ID(".$res."), Topic ID(".$topic.")");
                                    }
                                    else{
                                        $this->log_model->add('error', "New topic could not be added to the ePaper, ePaper ID(".$res."), Topic ID(".$topic.")");
                                    }
                                }
                            }
                            
                            $pages = $this->input->post('epaper_pages_counter');
                            for($i=1;$i<=$pages;$i++){
                                if($_FILES['epaper_image_'.$i]['name']!=""){
                                    
                                    $data = array();
                                    $data['epaper_id'] = $res;
                                    $data['page_num'] = $i;
                                    
                                    if($_FILES['epaper_image_' . $i]['type']=="application/pdf"){
                                        $config['upload_path']          = './public_html/upload/pdfs/';
                                    }
                                    else{
                                        $config['upload_path']          = './public_html/upload/images/';
                                    }
                                    
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|pdf';
                                    $config['max_size']             = 25000;

                                    $image_sizes = array(
                                        'small' => array(500, 500),
                                    );


                                    // get file extension
                                    $file_ext = pathinfo($_FILES["epaper_image_".$i]["name"], PATHINFO_EXTENSION);

                                    // change file name
                                    $_FILES['epaper_image_'.$i]['name'] = sha1(microtime()) . "." .$file_ext;

                                    //load library
                                    $this->load->library('upload', $config);

                                    if ( ! $this->upload->do_upload('epaper_image_'.$i))
                                    {
                                        $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                                        $this->response($return, 200);
                                    }
                                    else
                                    {

                                        $img_data = array('upload_data' => $this->upload->data());                            
                                        $data['thumbnail'] = $img_data['upload_data']['file_name'];
                                        $uploaded_image = $img_data['upload_data']['file_name'];

                                        if($_FILES['epaper_image_' . $i]['type']=="application/pdf"){
                                            $full_path = './public_html/upload/pdfs/'.$uploaded_image;
                                            $this->s3_bucket_upload($full_path, $uploaded_image,'pdfs');
                                        }
                                        else{
                                            $full_path = './public_html/upload/images/'.$uploaded_image;
                                            $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                                        }
                                        

                                        $small_image_link = "";
                                        $large_image_link = "";

                                        if($_FILES['epaper_image_' . $i]['type']!="application/pdf"){
                                            //creating thumbnails
                                            foreach ($image_sizes as $key=>$resize) {
                                                if($key=='small'){
                                                    $large_thumb_img_name = sha1(microtime()) . "." . $file_ext;
                                                    $small_image_link = $large_thumb_img_name;
                                                    $data['s_thumbnail'] = $large_thumb_img_name;
                                                }

                                                $large_config = array(
                                                    'source_image' => './public_html/upload/images/'.$uploaded_image,
                                                    'new_image' => './public_html/upload/images/'.$large_thumb_img_name,
                                                    'maintain_ration' => true,
                                                    'width' => $resize[0],
                                                    'height' => $resize[1]
                                                );
                                                $this->image_lib->initialize($large_config);
                                                if (!$this->image_lib->resize()) {
                                                    echo $this->image_lib->display_errors();
                                                }
                                                $full_path = './public_html/upload/images/'.$large_thumb_img_name;
                                                $res_s3_upload = $this->s3_bucket_upload($full_path, $large_thumb_img_name,'images');
                                                if($res_s3_upload['status']){
                                                    $this->unlink_file($large_thumb_img_name,'images');
                                                }
                                            }
                                            if($res_s3_upload['status']){
                                                $this->unlink_file($uploaded_image,'images');
                                            }
                                        }
                                            
                                        
                                        
                                        $r = $this->epaper_model->save_epaper_trans_details($this->_epaper_trans_table,$data);
                                        if($r){
                                            $this->log_model->add('info', "ePaper page number " . $i . " successfully uploaded.");
                                        }
                                        else{
                                            $this->log_model->add('error', "ePaper page number " . $i . " could not be uploaded.");
                                        }
                                    }
                                }
                            }
                        
                            $this->email_notification_model->send_android_push_notification(lang('pratibadi_kalam') . 'ই-পেপার আপলোড করা হয়েছে', "প্রতিবাদী কালাম ই-পেপার খুলতে এখানে ক্লিক করুন", "", "ePaper", $res);
                            
                            $return = array('status'=>TRUE,'message'=>lang('epaper_details_saved_successfully'),'next'=>$rand_id);
                        }
                        else{
                            $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                            $this->log_model->add('error', "New epaper could not be saved.");
                        }
                        $this->response($return, 200);
                    }   
                }
            }
                
        }
        catch (Exception $e)
        {
            echo 'ss';exit;
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
    public function delete_epaper_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['epaper_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->epaper_model->update_epaper_details($this->_epaper_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Video details deleted successfully. Video ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('epaper_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Video details could not be deleted, Video ID(" . $where['epaper_id'] . ")");
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
            'epaper'=>0,
            'events'=>0,
            'event'=>0,
            'tags'=>0,
            'packages'=>0,
            'package'=>0,
        );
        if($this->session->userdata('ds_user')){
            $return_stat['blogs'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'blogs');            
            $return_stat['reminders'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'reminders');            
            $return_stat['albums'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'albums');            
            $return_stat['bookings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'bookings');            
            $return_stat['live_streamings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'epaper',VIDEO_TYPE_LIVE_STREAMING);            
            $return_stat['epaper'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'epaper',VIDEO_TYPE_VIDEO);
            $return_stat['events'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'events');            
            $return_stat['event'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'event');            
            $return_stat['tags'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'tags');            
            $return_stat['packages'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'packages');            
            $return_stat['package'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'package');            
        }
        $this->response($return_stat, 200);
    }
    

/**
     * List GET
     *
     * Responds with information about all users available.
     *
     * @return string Data table supported JSON with users info
     */
    public function get_epaper_details_get()
    {

        try {
            
            $day = "";
            $month = "";
            $year = "";
            $auth_tkn = "";
            
            if($this->input->get('auth_tkn')){
                $auth_tkn = $this->input->get('auth_tkn');
            }
            
            if($this->input->get('day')){
                $day = $this->input->get('day');
            }
            if($this->input->get('month')){
                $month = $this->input->get('month');
            }
            if($this->input->get('year')){
                $year = $this->input->get('year');
            }
            
            if($day!="" && $month!="" && $year!="" && $auth_tkn=="kjhdf876dw86324nldkle9d90dq09e2jkdjfh487yd9qwdlakfnsjgkehituyrowerwelkr34ihifjkh"){
                $epaper_date = "";
                $epaper_date = date('Y-m-d', strtotime($day . "." . $month . "." . $year));
                
                if($epaper_date!="1970-01-01"){
                    $epaper_details = $this->epaper_model->get_where($this->_epaper_table, array('epaper_date'=>$epaper_date));
                    if(!empty($epaper_details)){
                        
                        //get epaper details
                        $epaper_pages_details = $this->epaper_model->get_where($this->_epaper_trans_table, array('epaper_id'=>$epaper_details[0]['epaper_id']));
                        
                        $result = array('status' => TRUE, 'epaper_details' => $epaper_details, "total_pages"=>count($epaper_pages_details), "epaper_pages"=>$epaper_pages_details);
                    }
                    else{
                        $result = array('status' => false, 'message' => lang('no_epaper_found'));
                    }
                }
                else{
                    $result = array('status' => false, 'message' => lang('msg_something_went_wrong'));
                }
            }
            else{
                $result = array('status' => false, 'message' => lang('msg_something_went_wrong'));
            }
            
            
            
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
