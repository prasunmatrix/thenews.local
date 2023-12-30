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
class Videos extends REST_Controller {
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_videos_table= 'videos';
        
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
        $this->lang->load('videos'); 
        $this->load->model('videos_model');
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
    public function list_videos_datatable_post()
    {

        try {
            
            $video = $this->videos_model->get_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($video as $video_type) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('video', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."videos/view/".$video_type->rand_id."'>". $video_type->video_title . "</a>";
                }
                else{
                    $row[] = $video_type->video_title;
                }
                
                $row[] = $video_type->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$video_type->date_created);
                
                $action = "";     
                if($this->permissions_model->check('video','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."videos/edit/".$video_type->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('video','delete')){
                    $action .= "&nbsp;&nbsp;<a onclick='delete_video(".$video_type->video_id.")'><i class='fa fa-trash-o'></i></a>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->videos_model->count_all(),
                "recordsFiltered" => $this->videos_model->count_filtered(),
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
    public function save_video_details_post()
    {
        
        $config = array();
        $config['image_library'] = 'gd2';
        $this->load->library('image_lib',$config);

        try {
            if($this->input->post('video_id')){
                //chheck form validation
                $run_validation = 'save_video_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['video_id'] = $this->input->post('video_id');
                    
                    $topics = $this->input->post('topics');
                    
                    $data = array();
                    if($_FILES['video_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["video_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['video_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('video_image'))
                        {
                            $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                            $this->response($return, 200);
                        }
                        else
                        {

                            $img_data = array('upload_data' => $this->upload->data());                            
                            $data['thumbnail'] = $img_data['upload_data']['file_name'];
                            $uploaded_image = $img_data['upload_data']['file_name'];
                            
                            $full_path = './public_html/upload/images/'.$uploaded_image;
                            $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                            
                            //load album watermark settings
                            $watermark_settings = $this->videos_model->get_where($this->_general_config_table,array('deleted'=>'0'));

                            $watermark_status = "";                        
                            $watermark_type = "";

                            $small_watermark_text= "";
                            $small_watermark_font_size= "";
                            $small_watermark_font_color= "";
                            $small_watermark_va= "";
                            $small_watermark_ha= "";
                            $small_watermark_image= "";

                            $large_watermark_text= "";
                            $large_watermark_font_size= "";
                            $large_watermark_font_color= "";
                            $large_watermark_va= "";
                            $large_watermark_ha= "";
                            $large_watermark_image= "";

                            foreach($watermark_settings as $config){
                                if($config['config_name']=='watermark_in_news'){
                                    $watermark_status = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_type'){
                                    $watermark_type = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_text'){
                                    $small_watermark_text = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_font_size'){
                                    $small_watermark_font_size = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_font_color'){
                                    $small_watermark_font_color = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_vertical_align'){
                                    $small_watermark_va = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_horizontal_align'){
                                    $small_watermark_ha = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_image'){
                                    $small_watermark_image = $config['config_value'];
                                }

                                if($config['config_name']=='watermark_large_thumn_text'){
                                    $large_watermark_text = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_font_size'){
                                    $large_watermark_font_size = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_font_color'){
                                    $large_watermark_font_color = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_vertical_align'){
                                    $large_watermark_va = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_horizontal_align'){
                                    $large_watermark_ha = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_image'){
                                    $large_watermark_image = $config['config_value'];
                                }
                            }

                            $small_image_link = "";
                            $large_image_link = "";

                            //creating thumbnails
                            foreach ($image_sizes as $key=>$resize) {
                                if($key=='large'){
                                    $large_thumb_img_name = sha1(microtime()) . "." . $file_ext;
                                    $large_image_link = $large_thumb_img_name;
                                    $data['l_thumbnail'] = $large_thumb_img_name;
                                }
                                else if($key=='small'){
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
                                if($watermark_status){                    
                                    //adding watermark for thumbnail
                                    $imgConfig = array();                        
                                    $imgConfig['source_image']  = $large_config['new_image'];
                                    if($watermark_type=='text'){
                                        $imgConfig['wm_text'] = $large_watermark_text;
                                        $imgConfig['wm_type'] = 'text';
                                        $imgConfig['wm_font_path'] = './public_html/fonts/arima-madurai/ArimaMadurai-ExtraBold.ttf';
                                        if($key=='large'){
                                            $imgConfig['wm_font_color'] = $large_watermark_font_color;
                                        $imgConfig['wm_font_size'] = $large_watermark_font_size;
                                        }
                                        else if($key=='small'){
                                            $imgConfig['wm_font_color'] = $small_watermark_font_color;
                                            $imgConfig['wm_font_size'] = $small_watermark_font_size;
                                        }
                                        
                                    }
                                    else if($watermark_type=='image'){
                                        $imgConfig['image_library'] = 'GD2';
                                        $imgConfig['wm_type'] = 'overlay';
                                        $imgConfig['wm_overlay_path'] = './public_html/upload/images/'.$large_watermark_image;
                                        $imgConfig['wm_opacity'] = 100;
                                    }
                                    $imgConfig['wm_vrt_alignment'] = $large_watermark_va;
                                    $imgConfig['wm_hor_alignment'] = $large_watermark_ha;
                                    $this->load->library('image_lib', $imgConfig);
                                    $this->image_lib->initialize($imgConfig);
                                    $this->image_lib->watermark();                     
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
                    }
                    $data['rand_id'] = $this->input->post('video_url');
                    
                    //check rand id is unique
                    $r_id = $this->videos_model->get_where($this->_videos_table,array('rand_id'=>$this->input->post('video_url'),'video_id!='=>$this->input->post('video_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('video_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('video_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }   
                    
                    $data['video_title'] = $this->input->post('video_title');
                    $data['video_desc'] = $this->input->post('video_desc');
                    $data['video_url'] = $this->input->post('yt_video_url');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->videos_model->update_video_details($this->_videos_table,$data, $where);
                    if($res){
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_VIDEOS;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of video, Video ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for video, Video ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_VIDEOS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the video, Video ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the video, Video ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        $this->log_model->add('info', "Video updated successfully, Video ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('video_details_updated_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "Video could not be updated. Video ID(" . $where['video_id'] . ")");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_video_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    if($_FILES['video_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["video_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['video_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('video_image'))
                        {
                            $return = array('status'=>FALSE, 'message' => $this->upload->display_errors());
                            $this->response($return, 200);
                        }
                        else
                        {

                            $img_data = array('upload_data' => $this->upload->data());                            
                            $data['thumbnail'] = $img_data['upload_data']['file_name'];
                            $uploaded_image = $img_data['upload_data']['file_name'];
                            
                            $full_path = './public_html/upload/images/'.$uploaded_image;
                            $this->s3_bucket_upload($full_path, $uploaded_image,'images');
                            
                            //load album watermark settings
                            $watermark_settings = $this->videos_model->get_where($this->_general_config_table,array('deleted'=>'0'));

                            $watermark_status = "";                        
                            $watermark_type = "";

                            $small_watermark_text= "";
                            $small_watermark_font_size= "";
                            $small_watermark_font_color= "";
                            $small_watermark_va= "";
                            $small_watermark_ha= "";
                            $small_watermark_image= "";

                            $large_watermark_text= "";
                            $large_watermark_font_size= "";
                            $large_watermark_font_color= "";
                            $large_watermark_va= "";
                            $large_watermark_ha= "";
                            $large_watermark_image= "";

                            foreach($watermark_settings as $config){
                                if($config['config_name']=='watermark_in_news'){
                                    $watermark_status = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_type'){
                                    $watermark_type = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_text'){
                                    $small_watermark_text = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_font_size'){
                                    $small_watermark_font_size = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_font_color'){
                                    $small_watermark_font_color = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_vertical_align'){
                                    $small_watermark_va = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_horizontal_align'){
                                    $small_watermark_ha = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_small_thumb_image'){
                                    $small_watermark_image = $config['config_value'];
                                }

                                if($config['config_name']=='watermark_large_thumn_text'){
                                    $large_watermark_text = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_font_size'){
                                    $large_watermark_font_size = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_font_color'){
                                    $large_watermark_font_color = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_vertical_align'){
                                    $large_watermark_va = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_horizontal_align'){
                                    $large_watermark_ha = $config['config_value'];
                                }
                                if($config['config_name']=='watermark_large_thumb_image'){
                                    $large_watermark_image = $config['config_value'];
                                }
                            }

                            $small_image_link = "";
                            $large_image_link = "";

                            //creating thumbnails
                            foreach ($image_sizes as $key=>$resize) {
                                if($key=='large'){
                                    $large_thumb_img_name = sha1(microtime()) . "." . $file_ext;
                                    $large_image_link = $large_thumb_img_name;
                                    $data['l_thumbnail'] = $large_thumb_img_name;
                                }
                                else if($key=='small'){
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
                                if($watermark_status){                    
                                    //adding watermark for thumbnail
                                    $imgConfig = array();                        
                                    $imgConfig['source_image']  = $large_config['new_image'];
                                    if($watermark_type=='text'){
                                        $imgConfig['wm_text'] = $large_watermark_text;
                                        $imgConfig['wm_type'] = 'text';
                                        $imgConfig['wm_font_path'] = './public_html/fonts/arima-madurai/ArimaMadurai-ExtraBold.ttf';
                                        if($key=='large'){
                                            $imgConfig['wm_font_color'] = $large_watermark_font_color;
                                        $imgConfig['wm_font_size'] = $large_watermark_font_size;
                                        }
                                        else if($key=='small'){
                                            $imgConfig['wm_font_color'] = $small_watermark_font_color;
                                            $imgConfig['wm_font_size'] = $small_watermark_font_size;
                                        }
                                        
                                    }
                                    else if($watermark_type=='image'){
                                        $imgConfig['image_library'] = 'GD2';
                                        $imgConfig['wm_type'] = 'overlay';
                                        $imgConfig['wm_overlay_path'] = './public_html/upload/images/'.$large_watermark_image;
                                        $imgConfig['wm_opacity'] = 100;
                                    }
                                    $imgConfig['wm_vrt_alignment'] = $large_watermark_va;
                                    $imgConfig['wm_hor_alignment'] = $large_watermark_ha;
                                    $this->load->library('image_lib', $imgConfig);
                                    $this->image_lib->initialize($imgConfig);
                                    $this->image_lib->watermark();                     
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
                    }
                    $topics = $this->input->post('topics');
                    $data['rand_id'] = $this->input->post('video_url');
                    //check rand id is unique
                    $r_id = $this->videos_model->get_where($this->_videos_table,array('rand_id'=>$this->input->post('video_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('video_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('video_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['video_title'] = $this->input->post('video_title');
                    $data['video_desc'] = $this->input->post('video_desc');
                    $data['video_url'] = $this->input->post('yt_video_url');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->videos_model->save_video_details($this->_videos_table,$data);
                    if($res){
                        $this->log_model->add('info', "New video saved successfully, Video ID(".$res.")");
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_VIDEOS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the video, Video ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the video, Video ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        $return = array('status'=>TRUE,'message'=>lang('new_video_details_saved_successfully'),'next'=>$rand_id);
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New video could not be saved.");
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
    public function delete_video_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['video_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->videos_model->update_video_details($this->_videos_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Video details deleted successfully. Video ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('video_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Video details could not be deleted, Video ID(" . $where['video_id'] . ")");
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
            $return_stat['live_streamings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'videos',VIDEO_TYPE_LIVE_STREAMING);            
            $return_stat['videos'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'videos',VIDEO_TYPE_VIDEO);
            $return_stat['events'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'events');            
            $return_stat['event'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'event');            
            $return_stat['tags'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'tags');            
            $return_stat['packages'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'packages');            
            $return_stat['package'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'),'package');            
        }
        $this->response($return_stat, 200);
    }
    
    
}
