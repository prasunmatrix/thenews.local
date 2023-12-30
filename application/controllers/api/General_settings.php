<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Blogs API
 *
 * @author		VR Patel
 * @copyright	Copyright (c) 2019, VR Patel.
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.vrpatel.in
 */

/**
 * @SWG\Resource(
 *     apiVersion="1.0",
 *     resourcePath="/Users",
 *     basePath="http://anjanayuvasangthan.in/en/api",
 *     description="Operations on Users"
 * )
 */

require (APPPATH.'libraries/REST_Controller.php');

/**
 * Class Users
 *
 */
class General_settings extends REST_Controller {

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
        $this->lang->load('general_settings');
        $this->load->model('general_settings_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');
    }

    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_email_setting_table = 'email_settings';
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_languages_table = 'languages';
    
    /**
     * List GET
     *
     * Responds with information about all users available.
     *
     * @return string Data table supported JSON with users info
     */
    public function save_client_details_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'save_studio_details';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['config_name'] = 'client_name';
                $data = array();
                $data['config_value'] = $this->input->post('studio_name');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] ='client_address';
                $data = array();
                $data['config_value'] = $this->input->post('client_address');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_phone1';
                $data = array();
                $data['config_value'] = $this->input->post('client_phone1');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_phone2';
                $data = array();
                $data['config_value'] = $this->input->post('client_phone2');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_phone3';
                $data = array();
                $data['config_value'] = $this->input->post('client_phone3');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_email1';
                $data = array();
                $data['config_value'] = $this->input->post('client_email1');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_email2';
                $data = array();
                $data['config_value'] = $this->input->post('client_email2');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_email3';
                $data = array();
                $data['config_value'] = $this->input->post('client_email3');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_city';
                $data = array();
                $data['config_value'] = $this->input->post('client_city');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_state';
                $data = array();
                $data['config_value'] = $this->input->post('client_state');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'client_pin_code';
                $data = array();
                $data['config_value'] = $this->input->post('client_pin_code');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);

                $where = array();
                $where['config_name'] = 'map_lang';
                $data = array();
                $data['config_value'] = $this->input->post('map_lang');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);

                $where = array();
                $where['config_name'] = 'map_lati';
                $data = array();
                $data['config_value'] = $this->input->post('map_lati');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'seo_title';
                $data = array();
                $data['config_value'] = $this->input->post('seo_title');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'seo_keywords';
                $data = array();
                $data['config_value'] = $this->input->post('seo_keywords');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] = 'seo_descriptions';
                $data = array();
                $data['config_value'] = $this->input->post('seo_descriptions');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $return = array('status'=>TRUE,'message'=>lang('studio_details_updated_successfully'));
                $this->log_model->add('info', "Studio details updated successfully.");
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
    public function save_date_format_details_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'save_date_format_details';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['config_name'] = 'date_format';
                $data = array();
                $data['config_value'] = $this->input->post('date_format');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] ='time_format';
                $data = array();
                $data['config_value'] = $this->input->post('time_format');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $where = array();
                $where['config_name'] ='timezone';
                $data = array();
                $data['config_value'] = $this->input->post('timezone');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                date_default_timezone_set($data['config_value']);
                
                $return = array('status'=>TRUE,'message'=>lang('date_and_time_format_updated_successfully'));
                $this->log_model->add('info', "Date and time format updated successfully.");
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
    public function save_email_signature_details_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'save_email_signature_details';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['config_name'] = 'email_signature';
                $data = array();
                $data['config_value'] = $this->input->post('email_signature');
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $return = array('status'=>TRUE,'message'=>lang('email_signature_updated_successfully'));
                $this->log_model->add('info', "Email signature updated successfully.");
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
    public function save_google_adsense_details_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'save_adsense_details';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['config_name'] = 'adsense_code';
                $data = array();
                $data['config_value'] = substr(strip_tags($this->input->post('adsense_code')),0,20);
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $return = array('status'=>TRUE,'message'=>lang('google_adsense_updated_successfully'));
                $this->log_model->add('info', "Google adsense updated successfully.");
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
    public function save_google_analytics_details_post()
    {

        try {
            
            //chheck form validation
            $run_validation = 'save_analytics_details';
            $this->form_validation->set_data($this->input->post());

            if ($this->form_validation->run($run_validation) == FALSE) {

                //return form validation errors
                $return = array('status' => false, 'message' => validation_errors());
                $this->response($return, 200);
            } 
            else {
                $where = array();
                $where['config_name'] = 'analytics_code';
                $data = array();
                $data['config_value'] = substr(strip_tags($this->input->post('tracking_id')),0,20);
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                
                $return = array('status'=>TRUE,'message'=>lang('google_analytics_updated_successfully'));
                $this->log_model->add('info', "Google analytics updated successfully.");
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
    public function save_social_media_links_details_post()
    {

        try {
            
            
            $where = array();
            $where['config_name'] = 'fb_url';
            $data = array();
            $data['config_value'] = $this->input->post('facebook');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'insta_url';
            $data = array();
            $data['config_value'] = $this->input->post('instagram');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'linkdin_url';
            $data = array();
            $data['config_value'] = $this->input->post('linkedin');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'youtube_url';
            $data = array();
            $data['config_value'] = $this->input->post('youtube');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'twitter_url';
            $data = array();
            $data['config_value'] = $this->input->post('twitter');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'whatsapp_number';
            $data = array();
            $data['config_value'] = $this->input->post('whatsapp');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'pinterest_url';
            $data = array();
            $data['config_value'] = $this->input->post('pinterest');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'tumblr_url';
            $data = array();
            $data['config_value'] = $this->input->post('tumblr');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);

            $return = array('status'=>TRUE,'message'=>lang('social_media_links_updated_successfully'));
            $this->log_model->add('info', "Social media links updated successfully.");
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
    public function save_watermark_settings_details_post()
    {

        try {
            
            if(isset($_FILES['watermark_small_thumb_image']['name'])){
                if($_FILES['watermark_small_thumb_image']['name']!=""){
                    $config['upload_path'] = './public_html/upload/images';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size'] = 25000;

                    $image_sizes = array(
                        'small' => array(450, 450),
                        'large' => array(1050, 1050)
                    );

                    // get file extension
                    $file_ext = pathinfo($_FILES["watermark_small_thumb_image"]["name"], PATHINFO_EXTENSION);

                    // change file name
                    $_FILES['watermark_small_thumb_image']['name'] = sha1(microtime()) . "." . $file_ext;

                    //load library
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('watermark_small_thumb_image')) {
                        $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
                        $this->response($return, 200);
                    } else {

                        $img_data = array('upload_data' => $this->upload->data());
                        $uploaded_image = $img_data['upload_data']['file_name'];
                            
//                        $full_path = './public_html/upload/images/'.$uploaded_image;
//                        $res_s3_upload = $this->s3_bucket_upload($full_path, $uploaded_image,'images');
//                        if($res_s3_upload['status']){
//                            $this->unlink_file($uploaded_image,'images');
//                        }
                        
                        $where = array();
                        $where['config_name'] = 'watermark_small_thumb_image';
                        $data = array();
                        $data['config_value'] = $uploaded_image;
                        $data['date_modified'] = now();
                        $data['user_modified'] = $this->session->userdata('ds_user');
                        $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                    }
                }
            }
            if(isset($_FILES['watermark_large_thumb_image']['name'])){
                if($_FILES['watermark_large_thumb_image']['name']!=""){

                    $config['upload_path'] = './public_html/upload/images';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size'] = 25000;

                    $image_sizes = array(
                        'small' => array(450, 450),
                        'large' => array(1050, 1050)
                    );

                    // get file extension
                    $file_ext = pathinfo($_FILES["watermark_large_thumb_image"]["name"], PATHINFO_EXTENSION);

                    // change file name
                    $_FILES['watermark_large_thumb_image']['name'] = sha1(microtime()) . "." . $file_ext;

                    //load library
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('watermark_large_thumb_image')) {
                        $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
                        $this->response($return, 200);
                    } else {

                        $img_data = array('upload_data' => $this->upload->data());
                        $uploaded_image = $img_data['upload_data']['file_name'];
                            
//                        $full_path = './public_html/upload/images/'.$uploaded_image;
//                        $res_s3_upload = $this->s3_bucket_upload($full_path, $uploaded_image,'images');
//                        if($res_s3_upload['status']){
//                            $this->unlink_file($uploaded_image,'images');
//                        }
                        
                        $where = array();
                        $where['config_name'] = 'watermark_large_thumb_image';
                        $data = array();
                        $data['config_value'] = $uploaded_image;
                        $data['date_modified'] = now();
                        $data['user_modified'] = $this->session->userdata('ds_user');
                        $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                    }
                }
            }
            
            $where = array();
            $where['config_name'] = 'watermark_type';
            $data = array();
            $data['config_value'] = $this->input->post('watermark_type');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_large_thumn_text';
            $data = array();
            $data['config_value'] = $this->input->post('large_thumb_watermark_text');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_large_thumb_font_size';
            $data = array();
            $data['config_value'] = $this->input->post('large_thumb_watermark_font_size');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_large_thumb_font_color';
            $data = array();
            $data['config_value'] = $this->input->post('large_thumb_watermark_font_color');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_large_thumb_vertical_align';
            $data = array();
            $data['config_value'] = $this->input->post('large_thumb_watermark_vertical_allignment');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_large_thumb_horizontal_align';
            $data = array();
            $data['config_value'] = $this->input->post('large_thumb_watermark_horizontal_allignment');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_small_thumb_text';
            $data = array();
            $data['config_value'] = $this->input->post('small_thumb_watermark_text');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_small_thumb_font_size';
            $data = array();
            $data['config_value'] = $this->input->post('small_thumb_watermark_font_size');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_small_thumb_font_color';
            $data = array();
            $data['config_value'] = $this->input->post('small_thumb_watermark_font_color');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_small_thumb_vertical_align';
            $data = array();
            $data['config_value'] = $this->input->post('small_thumb_watermark_vertical_allignment');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $where = array();
            $where['config_name'] = 'watermark_small_thumb_horizontal_align';
            $data = array();
            $data['config_value'] = $this->input->post('small_thumb_watermark_horizontal_allignment');
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('ds_user');
            $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
            
            $return = array('status'=>TRUE,'message'=>lang('watermark_settings_updated_successfully'));
            $this->log_model->add('info', "Watermark settings updated successfully.");
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
    public function save_website_logos_details_post()
    {

        try {
            
            if(isset($_FILES['white_logo']['name'])){
                if($_FILES['white_logo']['name']!=""){

                    $config['upload_path'] = './public_html/upload/images';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size'] = 25000;

                    // get file extension
                    $file_ext = pathinfo($_FILES["white_logo"]["name"], PATHINFO_EXTENSION);

                    // change file name
                    $_FILES['white_logo']['name'] = sha1(microtime()) . "." . $file_ext;

                    //load library
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('white_logo')) {
                        $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
                        $this->response($return, 200);
                    } else {

                        $img_data = array('upload_data' => $this->upload->data());
                        $uploaded_image = $img_data['upload_data']['file_name'];
                            
                        $full_path = './public_html/upload/images/'.$uploaded_image;
                        $res_s3_upload = $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                        if($res_s3_upload['status']){
                            $this->unlink_file($uploaded_image,'images');
                        }

                        $where = array();
                        $where['config_name'] = 'logo_white';
                        $data = array();
                        $data['config_value'] = $uploaded_image;
                        $data['date_modified'] = now();
                        $data['user_modified'] = $this->session->userdata('ds_user');
                        $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                        $this->log_model->add('info', "Website white logo updated successfully.");
                    }
                }
            }
            if(isset($_FILES['black_logo']['name'])){
                if($_FILES['black_logo']['name']!=""){

                    $config['upload_path'] = './public_html/upload/images';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size'] = 25000;

                    // get file extension
                    $file_ext = pathinfo($_FILES["black_logo"]["name"], PATHINFO_EXTENSION);

                    // change file name
                    $_FILES['black_logo']['name'] = sha1(microtime()) . "." . $file_ext;

                    //load library
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('black_logo')) {
                        $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
                        $this->response($return, 200);
                    } else {

                        $img_data = array('upload_data' => $this->upload->data());
                        $uploaded_image = $img_data['upload_data']['file_name'];
                            
                        $full_path = './public_html/upload/images/'.$uploaded_image;
                        $res_s3_upload = $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                        if($res_s3_upload['status']){
                            $this->unlink_file($uploaded_image,'images');
                        }
                        
                        $where = array();
                        $where['config_name'] = 'logo_black';
                        $data = array();
                        $data['config_value'] = $uploaded_image;
                        $data['date_modified'] = now();
                        $data['user_modified'] = $this->session->userdata('ds_user');
                        $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                        $this->log_model->add('info', "Website black logo updated successfully.");
                    }
                }
            }
            if(isset($_FILES['favicon_icon']['name'])){
                if($_FILES['favicon_icon']['name']!=""){

                    $config['upload_path'] = './public_html/upload/images';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size'] = 25000;

                    // get file extension
                    $file_ext = pathinfo($_FILES["favicon_icon"]["name"], PATHINFO_EXTENSION);

                    // change file name
                    $_FILES['favicon_icon']['name'] = sha1(microtime()) . "." . $file_ext;

                    //load library
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('favicon_icon')) {
                        $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
                        $this->response($return, 200);
                    } else {

                        $img_data = array('upload_data' => $this->upload->data());
                        $uploaded_image = $img_data['upload_data']['file_name'];
                            
                        $full_path = './public_html/upload/images/'.$uploaded_image;
                        $res_s3_upload = $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                        if($res_s3_upload['status']){
                            $this->unlink_file($uploaded_image,'images');
                        }
                        
                        $where = array();
                        $where['config_name'] = 'favicon_icon';
                        $data = array();
                        $data['config_value'] = $uploaded_image;
                        $data['date_modified'] = now();
                        $data['user_modified'] = $this->session->userdata('ds_user');
                        $this->general_settings_model->update_general_config_details($this->_general_config_table,$data,$where);
                        $this->log_model->add('info', "Website favicon icon updated successfully.");
                    }
                }
            }
            $return = array('status'=>TRUE,'message'=>lang('website_logos_updated_successfully'));            
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
    public function change_watermark_permission_details_post()
    {

        try {
            if($this->input->post('per')){

                    $where = array(); 
                    $where['config_id'] = $this->input->post('per');
                   
                    $c_data = array();
                    $c_data['config_value'] = $this->input->post('permission');
                    $c_data['date_modified'] = now();
                    $c_data['user_modified'] = $this->session->userdata('ds_user');

                    $res = $this->general_settings_model->update_general_config_details($this->_general_config_table,$c_data, $where);
                    
                    if($res){

                        $this->log_model->add('info', "Watermark permission updated successfully, config_id(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('watermark_permission_updated_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('watermark_permission_could_not_be_updated'));
                        $this->log_model->add('error', "Watermark permission could not be updated.");
                    }
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
    public function update_email_settings_post()
    {

        try {
            if($this->input->post('per')){

                    $where = array(); 
                    $where['config_id'] = $this->input->post('per');
                   
                    $c_data = array();
                    $c_data['config_value'] = $this->input->post('permission');
                    $c_data['date_modified'] = now();
                    $c_data['user_modified'] = $this->session->userdata('ds_user');

                    $res = $this->general_settings_model->update_general_config_details($this->_email_setting_table,$c_data, $where);
                    
                    if($res){

                        $this->log_model->add('info', "Email settings updated successfully, config_id(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('email_settings_updated_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('email_settings_could_not_be_updated'));
                        $this->log_model->add('error', "Email settings could not be updated.");
                    }
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
    public function update_language_settings_post()
    {

        try {
            if($this->input->post('per')){

                    $where = array(); 
                    $where['lang_id'] = $this->input->post('per');
                   
                    $c_data = array();
                    $c_data['visibility'] = $this->input->post('permission');
                    
                    $res = $this->general_settings_model->update_languages_details($this->_languages_table,$c_data, $where);
                    
                    if($res){

                        $this->log_model->add('info', "Language settings updated successfully, language_id(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('language_settings_updated_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('language_settings_could_not_be_updated'));
                        $this->log_model->add('error', "Language settings could not be updated.");
                    }
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
