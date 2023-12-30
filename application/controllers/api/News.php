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
class News extends REST_Controller {
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_bookmark_table= 'bookmarks';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
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
    public $_exclusive_news_table= 'exclusive_news';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_live_news_table= 'live_news';

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
    
    public $_date_format= 'd M, Y';    
    
    public $_time_format= 'H:i A';    
    
    public $configs = array();

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
        $this->lang->load('news');
        $this->load->model('news_model');
        $this->load->model('email_notification_model');
        $this->load->model('log_model');
        
        $general_config = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));
        
        if(!empty($general_config)){
            foreach($general_config as $config){
                $this->configs[$config['config_name']] = $config['config_value'];
            }
        }
        
        $this->_date_format = $this->configs['date_format'];
        $this->_time_format = $this->configs['time_format'];
        date_default_timezone_set($this->configs['timezone']);
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
    public function list_news_datatable_post()
    {
        try {
            
            $newss = $this->news_model->get_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('news', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."news/view/".$news->rand_id."'>". $news->news_title . "</a>";
                }
                else{
                    $row[] = $news->news_title;
                }
                if($this->permissions_model->check('news_types', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."news_types/view/".$news->news_type_rand_id."'>". $news->news_type_title . "</a>";
                }
                else{
                    $row[] = $news->news_type_title;
                }
                
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->date_created);
//                if($news->add_to_home_slider){
//                    $row[] = " <label class='switch'><input type='checkbox' id='news_".$news->news_id."' onchange='changeHomeSliderStatus(".$news->news_id.")' checked><span></span></label>";
//                }
//                else{
//                    $row[] = " <label class='switch'><input type='checkbox' id='news_".$news->news_id."' onchange='changeHomeSliderStatus(".$news->news_id.")'><span></span></label>";
//                }
                
                
                $action = "";     
                if($this->permissions_model->check('news','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."news/edit/".$news->rand_id."' class=''><i class='fa  fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news','delete')){
                    $action .= "&nbsp;&nbsp;<a href='#' onclick='delete_news(".$news->news_id.")'><i class='fa  fa-trash-o'></i></a>";
                }
                if($this->permissions_model->check('news','status')){
                    //$action .= "&nbsp;&nbsp;<label class='switch' style='display:inline;'  data-toggle='tooltip' data-placement='bottom' title='visit_website'><input type='checkbox' onchange='changeVisibility(".$news->news_id.")'><span></span></label>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_model->count_all(),
                "recordsFiltered" => $this->news_model->count_filtered(),
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
    public function list_live_sub_news_datatable_post()
    {
        

        try {
            $news_id = $this->input->post('live_news_id');
            
            $newss = $this->news_model->get_live_sub_news_datatables($news_id);
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                $row[] = $no;
                
                if($this->permissions_model->check('news', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."live_news/view/".$news->rand_id."'>". $news->news_title . "</a>";
                }
                else{
                    $row[] = $news->news_title;
                }
                
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->date_created);
                
                $action = "";     
                if($this->permissions_model->check('news','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."live_news/edit/".$news->rand_id."' class=''><i class='fa  fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news','delete')){
                    $action .= "&nbsp;&nbsp;<a href='#' onclick='delete_news(".$news->news_id.")'><i class='fa  fa-trash-o'></i></a>";
                }
                if($this->permissions_model->check('news','status')){
                    //$action .= "&nbsp;&nbsp;<label class='switch' style='display:inline;'  data-toggle='tooltip' data-placement='bottom' title='visit_website'><input type='checkbox' onchange='changeVisibility(".$news->news_id.")'><span></span></label>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_model->live_sub_news_count_all($news_id),
                "recordsFiltered" => $this->news_model->live_sub_news_count_filtered($news_id),
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
    public function list_exclusive_sub_news_datatable_post()
    {
        

        try {
            $news_id = $this->input->post('exclusive_news_id');
            
            $newss = $this->news_model->get_exclusive_sub_news_datatables($news_id);
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                $row[] = $no;
                
                if($this->permissions_model->check('news', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."exclusive_news/view/".$news->rand_id."'>". $news->news_title . "</a>";
                }
                else{
                    $row[] = $news->news_title;
                }
                
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->date_created);
                
                $action = "";     
                if($this->permissions_model->check('news','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."exclusive_news/edit/".$news->rand_id."' class=''><i class='fa  fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news','delete')){
                    $action .= "&nbsp;&nbsp;<a href='#' onclick='delete_news(".$news->news_id.")'><i class='fa  fa-trash-o'></i></a>";
                }
                if($this->permissions_model->check('news','status')){
                    //$action .= "&nbsp;&nbsp;<label class='switch' style='display:inline;'  data-toggle='tooltip' data-placement='bottom' title='visit_website'><input type='checkbox' onchange='changeVisibility(".$news->news_id.")'><span></span></label>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_model->exclusive_sub_news_count_all($news_id),
                "recordsFiltered" => $this->news_model->exclusive_sub_news_count_filtered($news_id),
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
    public function list_exclusive_news_datatable_post()
    {

        try {
            
            $newss = $this->news_model->get_exclusive_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('news', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."exclusive_news/view/".$news->rand_id."'>". $news->news_title . "</a>";
                }
                else{
                    $row[] = $news->news_title;
                }
                
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->date_created);
                
                $action = "";     
                if($this->permissions_model->check('news','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."exclusive_news/edit/".$news->rand_id."' class=''><i class='fa  fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news','delete')){
                    $action .= "&nbsp;&nbsp;<a href='#' onclick='delete_news(".$news->news_id.")'><i class='fa  fa-trash-o'></i></a>";
                }
                if($this->permissions_model->check('news','status')){
                    //$action .= "&nbsp;&nbsp;<label class='switch' style='display:inline;'  data-toggle='tooltip' data-placement='bottom' title='visit_website'><input type='checkbox' onchange='changeVisibility(".$news->news_id.")'><span></span></label>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_model->exclusive_count_all(),
                "recordsFiltered" => $this->news_model->exclusive_count_filtered(),
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
    public function list_live_news_datatable_post()
    {

        try {
            
            $newss = $this->news_model->get_live_datatables();
            
            $data = array();
            $no = $_REQUEST['start'];
            foreach ($newss as $news) {
                $no++;
                $row = array();
                $row[] = $no;
                if($this->permissions_model->check('news', 'view')){
                    $row[] = "<a class='text-capitalize' href='". site_url().DASHBOARD_DIR_NAME."live_news/view/".$news->rand_id."'>". $news->news_title . "</a>";
                }
                else{
                    $row[] = $news->news_title;
                }
                
                $row[] = $news->created_by;
                $row[] = date(DEFAULT_DATETIME_FORMAT,$news->date_created);
                
                $action = "";     
                if($this->permissions_model->check('news','edit')){
                    $action .= "<a href='". site_url().DASHBOARD_DIR_NAME."live_news/edit/".$news->rand_id."' class=''><i class='fa  fa-pencil'></i></a>";
                }
                if($this->permissions_model->check('news','delete')){
                    $action .= "&nbsp;&nbsp;<a href='#' onclick='delete_news(".$news->news_id.")'><i class='fa  fa-trash-o'></i></a>";
                }
                if($this->permissions_model->check('news','status')){
                    //$action .= "&nbsp;&nbsp;<label class='switch' style='display:inline;'  data-toggle='tooltip' data-placement='bottom' title='visit_website'><input type='checkbox' onchange='changeVisibility(".$news->news_id.")'><span></span></label>";
                }
                
                $row[] = $action;
                $data[] = $row;
            }

            $result = array(
                "draw" => $_REQUEST['draw'],
                "recordsTotal" => $this->news_model->live_count_all(),
                "recordsFiltered" => $this->news_model->live_count_filtered(),
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
    public function save_news_details_post()
    {

        try {
            $config = array();
            $config['image_library'] = 'gd2';
            $this->load->library('image_lib',$config);
        
            if($this->input->post('news_id')){
                //chheck form validation
                $run_validation = 'save_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['news_id'] = $this->input->post('news_id');
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                    $data['rand_id'] = $this->input->post('news_url');
                    $topics = $this->input->post('topics');
                    
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_news_table,array('rand_id'=>$this->input->post('news_url'),'news_id!='=>$this->input->post('news_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['news_title'] = $this->input->post('news_title');
                    $data['news_desc'] = $this->input->post('news_desc');
                    $data['news_type_id'] = $this->input->post('news_type');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->update_news_details($this->_news_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "News details updated successfully, News ID(".$res.")");
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_NEWS;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of news, News ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for news, News ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        
                        $return = array('status'=>TRUE,'message'=>lang('news_details_updated_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "News could not be updated. News ID(".$where['news_id'].")");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                                        $imgConfig['wm_font_color'] = $large_watermark_font_color;
                                        $imgConfig['wm_font_size'] = $large_watermark_font_size;
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
                    $data['rand_id'] = $this->input->post('news_url');
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_news_table,array('rand_id'=>$this->input->post('news_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    $news_title = $this->input->post('news_title');
                    $news_desc = $this->input->post('news_desc');
                    $data['news_title'] = $news_title;
                    $data['news_desc'] = $news_desc;
                    $data['news_type_id'] = $this->input->post('news_type');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->save_news_details($this->_news_table,$data);
                    if($res){
                        $this->log_model->add('info', "New news saved successfully, News ID(".$res.")");
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        
                        if($this->input->post('send_push_notification_to_app')=="1"){
                            if(!isset($large_thumb_img_name)){
                                $large_thumb_img_name = "";
                            }
                            $this->email_notification_model->send_android_push_notification($news_title, substr(strip_tags($news_desc) , 0, 100), S3_URL . S3_BUCKET_NAME . '/images/' . $large_thumb_img_name, "News", $res);
                        }

                        $return = array('status'=>TRUE,'message'=>lang('new_news_details_saved_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New news could not be saved.");
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
    
	//send push notification
    public function custom_push_notification_get()
    {
	$noti_title = "New Update available on Play Store";
	$noti_desc = "Open your phone play store and update Pratibadi Kalam to latest version for better performance.";
	$noti_thumb = "https://www.gstatic.com/android/market_images/web/play_prism_hlock_2x.png";
	$entity = "";
	$entity_id = "";

	$this->email_notification_model->send_android_push_notification($noti_title, $noti_desc, $noti_thumb, $entity, $entity_id);

	$result = array('status' => TRUE, 'data' => array(), 'message' => lang('success'));
	$this->response($result, 200);
    }


    /**
     * List GET
     *
     * Responds with information about all users available.
     *
     * @return string Data table supported JSON with users info
     */
    public function save_live_news_details_post()
    {

        try {
            $config = array();
            $config['image_library'] = 'gd2';
            $this->load->library('image_lib',$config);
        
            if($this->input->post('news_id')){
                //chheck form validation
                $run_validation = 'save_live_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['news_id'] = $this->input->post('news_id');
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                    $data['rand_id'] = $this->input->post('news_url');
                    $topics = $this->input->post('topics');
                    
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_live_news_table,array('rand_id'=>$this->input->post('news_url'),'news_id!='=>$this->input->post('news_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['news_title'] = $this->input->post('news_title');
                    $data['news_desc'] = $this->input->post('news_desc');
                    $data['parent_news_id'] = $this->input->post('parent_news');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->update_news_details($this->_live_news_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "Exclusive news details updated successfully, News ID(".$res.")");
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_LIVE_NEWS;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of Exclusive news, News ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for Exclusive news, News ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_LIVE_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        
                        $return = array('status'=>TRUE,'message'=>lang('live_news_details_updated_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "Exclusive News could not be updated. News ID(".$where['news_id'].")");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_live_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                                        $imgConfig['wm_font_color'] = $large_watermark_font_color;
                                        $imgConfig['wm_font_size'] = $large_watermark_font_size;
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
                    $data['rand_id'] = $this->input->post('news_url');
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_live_news_table,array('rand_id'=>$this->input->post('news_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    $news_title = $this->input->post('news_title');
                    $news_desc = $this->input->post('news_desc');
                    $data['news_title'] = $news_title;
                    $data['news_desc'] = $news_desc;
                    $data['parent_news_id'] = $this->input->post('parent_news');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->save_news_details($this->_live_news_table,$data);
                    if($res){
                        $this->log_model->add('info', "New Exclusive news saved successfully, News ID(".$res.")");
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_LIVE_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news, Exclusive News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        if($this->input->post('send_push_notification_to_app')=="1"){
                            $this->email_notification_model->send_android_push_notification($news_title, substr(strip_tags($news_desc) , 0, 100), S3_URL . S3_BUCKET_NAME . '/images/' . $large_thumb_img_name, "Live News", $res);
                        }
                        $return = array('status'=>TRUE,'message'=>lang('new_live_news_details_saved_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New Exclusive news could not be saved.");
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
    public function save_exclusive_news_details_post()
    {

        try {
            $config = array();
            $config['image_library'] = 'gd2';
            $this->load->library('image_lib',$config);
        
            if($this->input->post('news_id')){
                //chheck form validation
                $run_validation = 'save_exclusive_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {

                    $where = array(); 
                    $where['news_id'] = $this->input->post('news_id');
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                    $data['rand_id'] = $this->input->post('news_url');
                    $topics = $this->input->post('topics');
                    
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_exclusive_news_table,array('rand_id'=>$this->input->post('news_url'),'news_id!='=>$this->input->post('news_id')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    
                    $data['news_title'] = $this->input->post('news_title');
                    $data['news_desc'] = $this->input->post('news_desc');
                    $data['parent_news_id'] = $this->input->post('parent_news');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_modified'] = now();
                    $data['user_modified'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->update_news_details($this->_exclusive_news_table,$data,$where);
                    if($res){
                        $this->log_model->add('info', "Exclusive news details updated successfully, News ID(".$res.")");
                        //delete all topics
                        $t_where = array();
                        $t_where['entity'] = TOPICS_ENTITY_EXCLUSIVE_NEWS;
                        $t_where['entity_id'] = $res;
                        
                        $r = $this->log_model->update_topic_entities_details($this->_topic_entities_trans_table,$t_where);
                        if($r){
                            $this->log_model->add('info', "All topics deleted of Exclusive news, News ID(".$res.")");
                        }
                        else{
                            $this->log_model->add('error', "Topics could not be deleted for Exclusive news, News ID(".$res.")");
                        }
                        
                        //add new tags
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_EXCLUSIVE_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        
                        $return = array('status'=>TRUE,'message'=>lang('exclusive_news_details_updated_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "Exclusive News could not be updated. News ID(".$where['news_id'].")");
                    }
                    $this->response($return, 200);
                }
            }
            else{
                //chheck form validation
                $run_validation = 'save_exclusive_news_details';
                $this->form_validation->set_data($this->input->post());

                if ($this->form_validation->run($run_validation) == FALSE) {

                    //return form validation errors
                    $return = array('status' => false, 'message' => validation_errors());
                    $this->response($return, 200);
                } 
                else {
                    
                    $data = array();
                    if($_FILES['news_image']['name']!=""){

                        $config['upload_path']          = './public_html/upload/images/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size']             = 25000;

                        $image_sizes = array(
                            'large' => array(1250, 1250),
                            'small' => array(850, 850),
                        );

                                
                        // get file extension
                        $file_ext = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);

                        // change file name
                        $_FILES['news_image']['name'] = sha1(microtime()) . "." .$file_ext;

                        //load library
                        $this->load->library('upload', $config);

                        if ( ! $this->upload->do_upload('news_image'))
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
                            $watermark_settings = $this->news_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                                        $imgConfig['wm_font_color'] = $large_watermark_font_color;
                                        $imgConfig['wm_font_size'] = $large_watermark_font_size;
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
                    $data['rand_id'] = $this->input->post('news_url');
                    //check rand id is unique
                    $r_id = $this->news_model->get_where($this->_exclusive_news_table,array('rand_id'=>$this->input->post('news_url')));
                    if(empty($r_id)){
                        $data['rand_id'] = $this->input->post('news_url');
                        $rand_id = $data['rand_id'];
                    }
                    else{
                        $data['rand_id'] = $this->input->post('news_url'). '-' . random_string('alnum',6);
                        $rand_id = $data['rand_id'];
                    }  
                    $news_title = $this->input->post('news_title');
                    $news_desc = $this->input->post('news_desc');
                    $data['news_title'] = $news_title;
                    $data['news_desc'] = $news_desc;
                    $data['parent_news_id'] = $this->input->post('parent_news');
                    $data['lang'] = $this->uri->segment(1);
                    $data['seo_title'] = $this->input->post('seo_title');
                    $data['seo_keywords'] = $this->input->post('seo_keyword');
                    $data['seo_desc'] = $this->input->post('seo_desc');
                    
                    $data['date_created'] = now();
                    $data['user_created'] = $this->session->userdata('ds_user');


                    $res = $this->news_model->save_news_details($this->_exclusive_news_table,$data);
                    if($res){
                        $this->log_model->add('info', "New Exclusive news saved successfully, News ID(".$res.")");
                        if(!empty($topics)){
                            foreach($topics as $topic){
                                $data = array();
                                $data['entity'] = TOPICS_ENTITY_EXCLUSIVE_NEWS;
                                $data['entity_id'] = $res;
                                $data['topic_id'] = $topic;
                                
                                $r = $this->log_model->save_topic_entities_details($this->_topic_entities_trans_table,$data);
                                if($r){
                                    $this->log_model->add('info', "New topic added successfully to the Exclusive news, News ID(".$res."), Topic ID(".$topic.")");
                                }
                                else{
                                    $this->log_model->add('error', "New topic could not be added to the news, Exclusive News ID(".$res."), Topic ID(".$topic.")");
                                }
                            }
                        }
                        
                        if($this->input->post('send_push_notification_to_app')=="1"){
                            $this->email_notification_model->send_android_push_notification($news_title, substr(strip_tags($news_desc) , 0, 100), S3_URL . S3_BUCKET_NAME . '/images/' . $large_thumb_img_name, "Exclusive News", $res);
                        }
                        $return = array('status'=>TRUE,'message'=>lang('new_exclusive_news_details_saved_successfully'),'next'=>$rand_id);

                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                        $this->log_model->add('error', "New Exclusive news could not be saved.");
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
    public function delete_news_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['news_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->news_model->update_news_details($this->_news_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "News details deleted successfully. News ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('news_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "News details could not be deleted, News ID(" . $where['news_id'] . ")");
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
    public function delete_live_news_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['news_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->news_model->update_news_details($this->_live_news_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Live News details deleted successfully. News ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('live_news_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Live News details could not be deleted, News ID(" . $where['news_id'] . ")");
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
    public function delete_exclusive_news_details_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $where = array();
                $where['news_id'] = $this->input->post('id');
                
                $data = array();
                $data['deleted'] = '1';
                $data['date_modified'] = now();
                $data['user_modified'] = $this->session->userdata('ds_user');
                
                 $res = $this->news_model->update_news_details($this->_exclusive_news_table,$data, $where);
                if($res){                    
                    $this->log_model->add('info', "Exclusive News details deleted successfully. News ID(".$res.")");
                    $return = array('status'=>TRUE,'message'=>lang('exclusive_news_details_deleted_successfully'));
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->log_model->add('error', "Exclusive News details could not be deleted, News ID(" . $where['news_id'] . ")");
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
    public function get_recent_news_posts_post()
    {

        try {
            
            if ($this->input->post('posts')) {
                
                $posts = $this->input->post('posts');
                $news_posts = $this->news_model->get_latest_posts($posts);
                $recent_post_html = "";
                
                if(!empty($news_posts)){
                    $count =0;
                    foreach($news_posts as $news){
                        //print_r($news);
                        if($count==0){
                            $recent_post_html .="<div class='grid-sizer'></div>";
                        }
                        $recent_post_html .="<div class='tg-post tg-masonrygrid'>";
                            $recent_post_html .="<figure>";
                                $recent_post_html .="<a href='" . site_url() . "news/view/" . $news['rand_id'] . "'><img src='".S3_URL.S3_BUCKET_NAME."/images/".$news['s_thumbnail']."' title='" . $news['seo_title'] . "' alt='" . $news['seo_title'] . "'></a>";
                                $recent_post_html .="<a href='" . site_url() . "category/view/" . $news['news_type_rand_id'] . "'><span class='tg-postcategory'>" . $news['news_type_title'] . "</span></a>";
                            $recent_post_html .="</figure>";
                            $recent_post_html .="<div class='tg-postcontent'>";
                                $recent_post_html .="<div class='tg-posttitle'>";
                                    $recent_post_html .="<h3><a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>" . $news['news_title'] . "</a></h3>";
                                $recent_post_html .="</div>";
                                $recent_post_html .="<div class='tg-description'>";
                                    $recent_post_html .="<p>" . mb_strimwidth($news['news_desc'], 0, 97, '...') . "</p>";
                                $recent_post_html .="</div>";
                                $recent_post_html .="<ul class='tg-postmetadata'>";
                                    $recent_post_html .="<li>";
                                        if($news['user_avatar']!=""){
                                            $recent_post_html .="<figure><a href='" . site_url() . "author/view/" . $news['user_rand_id'] . "'><img src='".S3_URL.S3_BUCKET_NAME."/images/".$news['user_avatar']."'  class='author-avatar-small' alt='" . $news['user_rand_id'] . "'></a></figure>";
                                        }
                                        else{
                                            $recent_post_html .="<figure><a href='" . site_url() . "author/view/" . $news['user_rand_id'] . "'><img src='/public_html/images/user.png' alt='" . $news['user_rand_id'] . "' class='author-avatar-small'></a></figure>";
                                        }
                                            
                                        $recent_post_html .="<span>By <a href='" . site_url() . "author/view/" . $news['user_rand_id'] . "'>" . $news['created_by'] . "</a></span>";
                                    $recent_post_html .="</li>";
                                    $recent_post_html .="<li><time datetime='" . date('Y-m-d',$news['date_created']). "'>" . date($this->_date_format,$news['date_created']) . "</time></li>";
                                $recent_post_html .="</ul>";
                            $recent_post_html .="</div>";
                        $recent_post_html .="</div>";
                        $count++;
                    }
                }
                
                $return = array('status'=>TRUE,'recent_posts'=> $recent_post_html);
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
    public function get_category_posts_post()
    {

        try {
            
            if ($this->input->post('news_category')) {
                
                $news_category = $this->input->post('news_category');
                $news_id = $this->input->post('news_id');
                $news_posts = $this->news_model->get_latest_category_posts($news_category,$news_id,6);
                $html = "";
                
                $count = 0;
                if(!empty($news_posts)){
                    foreach($news_posts as $news){
                        $author_img_src = "";
                        if($news['user_avatar']!=""){
                            $author_img_src = S3_URL.S3_BUCKET_NAME . "/images/" . $news['user_avatar'];
                        }
                        else{
                            $author_img_src = "/public_html/images/user.png";
                        }
                                            
                        if($count%2==0){
                            $html .= "<div class='col-xs-6 col-sm-6' style='border: 1px solid #e7e7e7;padding-bottom: 5px;padding-top: 20px;padding-left:0px;padding-right:0px;'>";
                                $html .= "<div class='col-sm-6'>";
                                    $html .= "<a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>";
                                    if($news['l_thumbnail']!=""){
                                        $html .= "<img src='" . S3_URL . S3_BUCKET_NAME . "/images/" . $news['l_thumbnail'] . "' alt='".$news['seo_title']."' title='".$news['seo_title']."' style='height:100px;'></a>";
                                    }
                                    else{
                                        $html .= "<img src='/public_html/images/thumbnail.png' alt='".$news['seo_title']."' title='".$news['seo_title']."'></a>";
                                    }
                                $html .= "</div>";
                                $html .= "<div class='col-sm-6'>";
                                    $html .= "<div>";
                                        $html .= "<h3 style='font-size:15px;margin-top:8px;'><a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>" . mb_strimwidth($news['news_title'], 0, 50, '...') . "</a></h3>";
                                    $html .= "</div>";
                                    $html .= "<ul class='tg-postmetadata'>";
                                        $html .= "<li>";
                                            $html .= "<span><a href='" . site_url() . "category/view/" . $news['news_type_rand_id'] . "'>".$news['news_type_title']."</a></span>";
                                        $html .= "</li>";
                                        $html .= "<li><time datetime='".date('Y-m-d',$news['date_created'])."'>".date($this->configs['date_format'],$news['date_created'])."</time></li>";
                                    $html .= "</ul>";
                                $html .= "</div>";
                            $html .= "</div>";
                        }
                        else{
                            $html .= "<div class='col-xs-6 col-sm-6' style='border: 1px solid #e7e7e7; border-left: 0px; padding-bottom: 5px;padding-top: 20px;padding-left:0px;padding-right:0px;'>";
                                $html .= "<div class='col-sm-6'>";
                                    $html .= "<a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>";
                                        if($news['l_thumbnail']!=""){
                                            $html .= "<img src='" . S3_URL . S3_BUCKET_NAME . "/images/" . $news['l_thumbnail'] . "' alt='".$news['seo_title']."' title='".$news['seo_title']."' style='height:100px;'></a>";
                                        }
                                        else{
                                            $html .= "<img src='/public_html/images/thumbnail.png' alt='".$news['seo_title']."' title='".$news['seo_title']."'></a>";
                                        }
                                $html .= "</div>";
                                $html .= "<div class='col-sm-6'>";
                                    $html .= "<div>";
                                        $html .= "<h3 style='font-size:15px;margin-top:8px;'><a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>" . mb_strimwidth($news['news_title'], 0, 50, '...') . "</a></h3>";
                                    $html .= "</div>";
                                    $html .= "<ul class='tg-postmetadata'>";
                                        $html .= "<li>";
                                            $html .= "<span><a href='" . site_url() . "category/view/" . $news['news_type_rand_id'] . "'>".$news['news_type_title']."</a></span>";
                                        $html .= "</li>";
                                        $html .= "<li><time datetime='".date('Y-m-d',$news['date_created'])."'>".date($this->configs['date_format'],$news['date_created'])."</time></li>";
                                    $html .= "</ul>";
                                $html .= "</div>";
                            $html .= "</div>";
                        }
                        $count++;
                        
                    }
                }
                
                $return = array('status'=>TRUE,'posts'=> $html);
                
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
    public function get_view_posts_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $news_type_id = $this->input->post('id');
                $news_id = $this->input->post('nid');
                $topics = $this->input->post('topics');
                
                $where = "";
                $topics = explode(',', $topics);
                $first = 0;
                foreach($topics as $topic){
                    if($topic!=""){
                        if($first==0){
                            $where .= "topic_entities_trans.topic_id=".$topic;
                        }
                        else{
                            $where .= " OR topic_entities_trans.topic_id=".$topic;
                        }
                        $first++;
                    }
                }
                $editor_picks_where = "(".$where.") AND topic_entities_trans.entity='".TOPICS_ENTITY_NEWS."' AND news.news_id!=".$news_id;
                $res = $this->news_model->get_latest_category_posts($news_type_id,$news_id,9);
                
                $editor_picks = $this->news_model->get_editor_picks($editor_picks_where,10);
                $trending_posts = $this->news_model->get_trending_news(5);
                
                
                $top_features_post = array();
                $recommended_posts = array();
                $count = 0;
                foreach($res as $news){
                    if($count<6){
                        $recommended_posts[] = $news;
                    }
                    else{
                        $top_features_post[] = $news;
                    }
                    $count++;
                }
                $featured_post_html = "";
                $recommended_posts_html = "";
                $editor_picks_html = "";
                $trending_posts_html = "";
                foreach($top_features_post as $post){
                    $featured_post_html .= "<div class='columns column-2'>";
                        $featured_post_html .= "<article class='extra-post-box'>";
                            $featured_post_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' class='extra-post-link'>";
                                $featured_post_html .= "<div class='post-image'>";
                                    $featured_post_html .= "<span><img src='".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail']."' width='80' height='80'></span>";
                                $featured_post_html .= "</div>";
                                $featured_post_html .= "<div class='post-title'>";
                                    $featured_post_html .= $post['news_title'];
                                    $featured_post_html .= "<span class='post-date'>".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."</span>";
                                $featured_post_html .= "</div>";
                            $featured_post_html .= "</a>";
                        $featured_post_html .= "</article>";
                    $featured_post_html .= "</div>";
                }
                foreach($recommended_posts as $post){
                    $recommended_posts_html .= "<div class='columns column-2' style='padding:5px;'>";
                        $recommended_posts_html .= "<article class='post-box' style='background-image: url(".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail'].");'>";
                            $recommended_posts_html .= "<div class='post-overlay'>";
                                $recommended_posts_html .= "<a href='". site_url() ."category/view/".$post['news_type_rand_id']."' class='post-category' title='Title of blog post' rel='tag'>".$post['news_type_title']."</a>";
                                $recommended_posts_html .= "<h3 class='post-title'>".$post['news_title']."</h3>";
                                $recommended_posts_html .= "<div class='post-meta'>";
                                    $recommended_posts_html .= "<div class='post-meta-author-avatar'>";
                                        $recommended_posts_html .= "<img alt='avatar' src='/public_html/upload/user_avatars/user.png' class='avatar' height='24' width='24'>";
                                    $recommended_posts_html .= "</div>";
                                    $recommended_posts_html .= "<div class='post-meta-author-info'>";
                                        $recommended_posts_html .= "<span class='post-meta-author-name'>";
                                            $recommended_posts_html .= "<a href='#' title='Posts by ".$post['created_by']."' rel='author'>".$post['created_by']."</a>&nbsp;";
                                        $recommended_posts_html .= "</span>";
                                        $recommended_posts_html .= "<span class='middot'>·</span>";
                                        $recommended_posts_html .= "<span class='post-meta-date'>";
                                            $recommended_posts_html .= "&nbsp;<abbr class='published updated' title='".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."'>".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."</abbr>";
                                        $recommended_posts_html .= "</span>";
                                    $recommended_posts_html .= "</div>";
                                $recommended_posts_html .= "</div>";
                            $recommended_posts_html .= "</div>";
                            $recommended_posts_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' class='post-overlayLink'></a>";
                        $recommended_posts_html .= "</article>";
                    $recommended_posts_html .= "</div>";
                }
                $total_posts = 1;
                foreach($editor_picks as $post){
                    if($total_posts==1){
                        $editor_picks_html .= "<li class='active'>";
                    }
                    else{
                        $editor_picks_html .= "<li>";
                    }                    
                        $editor_picks_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' style='background-image: url(".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail'].");'>";
                            $editor_picks_html .= "<div class='box-wrapper'>";
                                $editor_picks_html .= "<div class='box-left'>";
                                    $editor_picks_html .= "<span>".$total_posts."</span>";
                                $editor_picks_html .= "</div>";
                                $editor_picks_html .= "<div class='box-right'>";
                                    $editor_picks_html .= "<h3 class='p-title'>".$post['news_title']."</h3>";
                                    $editor_picks_html .= "<div class='p-icons'>";
                                        $editor_picks_html .= $post['created_by'] . " &nbsp; " . date(DEFAULT_DATETIME_FORMAT,$post['date_created']);
                                    $editor_picks_html .= "</div>";
                                $editor_picks_html .= "</div>";
                            $editor_picks_html .= "</div>";
                        $editor_picks_html .= "</a>";
                    $editor_picks_html .= "</li>";
                    $total_posts++;
                }
                $count =0;
                foreach($trending_posts as $post){
                    if($count==1){
                        $class_name = "active";
                    }
                    else{
                        $class_name = "";
                    }
                    
                    $trending_posts_html .= "<article class='extra-post-box'>";
                        $trending_posts_html .= "<a href='".site_url()."news/view/".$post['rand_id']."' class='extra-post-link'>";
                            $trending_posts_html .= "<div class='post-image'>";
                                $trending_posts_html .= "<span><img src='".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail']."' width='80' height='80'></span>";
                            $trending_posts_html .= "</div>";
                            $trending_posts_html .= "<div class='post-title'>";
                                $trending_posts_html .= $post['news_title'];
                                $trending_posts_html .= "<span class='post-date'></span>";
                            $trending_posts_html .= "</div>";
                        $trending_posts_html .= "</a>";
                    $trending_posts_html .= "</article>";
                    $count++;
                }
                $return = array('status'=>TRUE,'featured_post'=> $featured_post_html,'recommended_posts'=>$recommended_posts_html,'editor_picks'=>$editor_picks_html,'trending_posts'=>$trending_posts_html);
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
    public function get_topic_data_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $topic_id = $this->input->post('id');
                
                $latest_news = $this->news_model->get_latest_posts(10);
                
                $news = $this->news_model->get_news_by_topic_id($topic_id,10);
                
                $latest_news_html = "";
                $total_posts = 1;
                foreach($latest_news as $post){
                    if($total_posts==1){
                        $latest_news_html .= "<li class='active'>";
                    }
                    else{
                        $latest_news_html .= "<li>";
                    }                    
                        $latest_news_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' style='background-image: url(".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail'].");'>";
                            $latest_news_html .= "<div class='box-wrapper'>";
                                $latest_news_html .= "<div class='box-left'>";
                                    $latest_news_html .= "<span>".$total_posts."</span>";
                                $latest_news_html .= "</div>";
                                $latest_news_html .= "<div class='box-right'>";
                                    $latest_news_html .= "<h3 class='p-title'>".$post['news_title']."</h3>";
                                    $latest_news_html .= "<div class='p-icons'>";
                                        $latest_news_html .= $post['created_by'] . " &nbsp; " . date(DEFAULT_DATETIME_FORMAT,$post['date_created']);
                                    $latest_news_html .= "</div>";
                                $latest_news_html .= "</div>";
                            $latest_news_html .= "</div>";
                        $latest_news_html .= "</a>";
                    $latest_news_html .= "</li>";
                    $total_posts++;
                }
                $news_html = "";
                foreach($news as $post){
                    $news_html .= "<div class='columns column-3'>";
                        $news_html .= "<div class='post-list-item'>";
                            $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."'>";
                            $news_html .= "<div class='post-top'>";
                                $news_html .= "<img class='post-image' src='".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail']."'>";
                                
                                $news_html .= "<h3 class='post-title'>";
                                $news_html .= "<span>".$post['news_title']."</span>";
                                $news_html .= "</h3>";
                            $news_html .= "</div>";
                            $news_html .= "</a>";
                            $news_html .= "<div class='post-bottom'>";
                                $news_html .= "<div class='post-author-box'>";
                                    $news_html .= "<span class='author-avatar'><img alt='avatar' src='/public_html/assets/images/avatar.jpg' class='avatar' height='24' width='24'></span>";
                                    $news_html .= "<a href='#' class='author-name'>".$post['created_by']."</a>";
                                    $news_html .= "<span class='post-date'>".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."</span>";
                                $news_html .= "</div>";
                                $news_html .= "<div class='post-meta'>";
                                    $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."' class='read-more'>".lang('read_more')."<i class='material-icons'>&#xE315;</i></a>";
                                    $news_html .= "<a href='". site_url()."category/view/".$post['news_type_rand_id']."' class='read-more' style='float:right;'>".$post['news_type_title']."</a>";
                                $news_html .= "</div>";
                            $news_html .= "</div>";
                        $news_html .= "</div>";
                    $news_html .= "</div>";
                }
                
                $return = array('status'=>TRUE,'latest_news'=> $latest_news_html,'news'=>$news_html);
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
    public function get_category_data_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $news_type_id = $this->input->post('id');
                
                $latest_news = $this->news_model->get_latest_posts(3);
                
                $news = $this->news_model->get_post_by_news_id_details($news_type_id);             
                
                $latest_news_html = "";
                $total_posts = 1;
                foreach($latest_news as $post){
                    if($total_posts==1){
                        $latest_news_html .= "<li class='active'>";
                    }
                    else{
                        $latest_news_html .= "<li>";
                    }                    
                        $latest_news_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' style='background-image: url(".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail'].");'>";
                            $latest_news_html .= "<div class='box-wrapper'>";
                                $latest_news_html .= "<div class='box-left'>";
                                    $latest_news_html .= "<span>".$total_posts."</span>";
                                $latest_news_html .= "</div>";
                                $latest_news_html .= "<div class='box-right'>";
                                    $latest_news_html .= "<h3 class='p-title'>".$post['news_title']."</h3>";
                                    $latest_news_html .= "<div class='p-icons'>";
                                        $latest_news_html .= $post['created_by'] . " &nbsp; " . date(DEFAULT_DATETIME_FORMAT,$post['date_created']);
                                    $latest_news_html .= "</div>";
                                $latest_news_html .= "</div>";
                            $latest_news_html .= "</div>";
                        $latest_news_html .= "</a>";
                    $latest_news_html .= "</li>";
                    $total_posts++;
                }
                $news_html = "";
                if(!empty($news)){
                    foreach($news as $post){
                        $news_html .= "<div class='columns column-3'>";
                            $news_html .= "<div class='post-list-item'>";
                                $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."'>";
                                $news_html .= "<div class='post-top'>";
                                    $news_html .= "<img class='post-image' src='".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail']."'>";

                                    $news_html .= "<h3 class='post-title'>";
                                    $news_html .= "<span>".$post['news_title']."</span>";
                                    $news_html .= "</h3>";
                                $news_html .= "</div>";
                                $news_html .= "</a>";
                                $news_html .= "<div class='post-bottom'>";
                                    $news_html .= "<div class='post-author-box'>";
                                        $news_html .= "<span class='author-avatar'><img alt='avatar' src='/public_html/assets/images/avatar.jpg' class='avatar' height='24' width='24'></span>";
                                        $news_html .= "<a href='#' class='author-name'>".$post['created_by']."</a>";
                                        $news_html .= "<span class='post-date'>".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."</span>";
                                    $news_html .= "</div>";
                                    $news_html .= "<div class='post-meta'>";
                                        $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."' class='read-more'>".lang('read_more')."<i class='material-icons'>&#xE315;</i></a>";
                                    $news_html .= "</div>";
                                $news_html .= "</div>";
                            $news_html .= "</div>";
                        $news_html .= "</div>";
                    }
                }
                else{
                    $news_html .= "<div class='col-md-12'>";                    
                        $news_html .= "<p>". lang('no_post_found')."</p>";
                    $news_html .= "</div>";
                }
                
                $return = array('status'=>TRUE,'latest_news'=> $latest_news_html,'news'=>$news_html);
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
    public function get_search_posts_post()
    {

        try {
            
            if ($this->input->post('id')) {
                
                $query = $this->input->post('id');
                //insert query
                $v_stat_data = array();
                if ($this->session->userdata('visitor_session') == '') {
                    $session = random_string('alnum',50);
                    $this->session->set_userdata('visitor_session',$session);
                }
                else{
                    $session = $this->session->userdata('visitor_session');
                }
                $v_stat_data['session_id'] = $session;
                if($this->session->userdata('ds_user')){
                    $v_stat_data['user_id'] = $this->session->userdata('ds_user');
                }
                else{
                    $v_stat_data['user_id'] = 0;
                }
                $v_stat_data['browser'] = $this->agent->browser() . ' ' . $this->agent->version();
                $v_stat_data['os'] = $this->agent->platform();
                $v_stat_data['ip'] = $this->input->ip_address();
                $v_stat_data['rand_id'] = random_string('alnum',6);
                $v_stat_data['query'] = $query;
                
                $getloc = json_decode(file_get_contents("http://ipinfo.io/"));

                $v_stat_data['city'] = $getloc->city;
                $v_stat_data['region'] = $getloc->region;
                $v_stat_data['country'] = $getloc->country;
                $v_stat_data['loc'] = $getloc->loc;
                $v_stat_data['org'] = $getloc->org;
                $v_stat_data['timezone'] = $getloc->timezone;
                $v_stat_data['url'] = current_url();
                $v_stat_data['timestamp'] = time();
                $this->log_model->save_stat('search_results',$v_stat_data);
                
                //get results
                $latest_news = $this->news_model->get_latest_posts(3);
                
                $news = $this->news_model->search_news_by_query($query);             
                
                $latest_news_html = "";
                $total_posts = 1;
                foreach($latest_news as $post){
                    if($total_posts==1){
                        $latest_news_html .= "<li class='active'>";
                    }
                    else{
                        $latest_news_html .= "<li>";
                    }                    
                        $latest_news_html .= "<a href='". site_url() ."news/view/".$post['rand_id']."' style='background-image: url(".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail'].");'>";
                            $latest_news_html .= "<div class='box-wrapper'>";
                                $latest_news_html .= "<div class='box-left'>";
                                    $latest_news_html .= "<span>".$total_posts."</span>";
                                $latest_news_html .= "</div>";
                                $latest_news_html .= "<div class='box-right'>";
                                    $latest_news_html .= "<h3 class='p-title'>".$post['news_title']."</h3>";
                                    $latest_news_html .= "<div class='p-icons'>";
                                        $latest_news_html .= $post['created_by'] . " &nbsp; " . date(DEFAULT_DATETIME_FORMAT,$post['date_created']);
                                    $latest_news_html .= "</div>";
                                $latest_news_html .= "</div>";
                            $latest_news_html .= "</div>";
                        $latest_news_html .= "</a>";
                    $latest_news_html .= "</li>";
                    $total_posts++;
                }
                $news_html = "";
                if(!empty($news)){
                    foreach($news as $post){
                        $news_html .= "<div class='columns column-3'>";
                            $news_html .= "<div class='post-list-item'>";
                                $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."'>";
                                $news_html .= "<div class='post-top'>";
                                    $news_html .= "<img class='post-image' src='".S3_URL.S3_BUCKET_NAME."/images/".$post['s_thumbnail']."'>";
                                    $news_html .= "<h3 class='post-title'>";
                                    $news_html .= "<span>".$post['news_title']."</span>";
                                    $news_html .= "</h3>";
                                $news_html .= "</div>";
                                $news_html .= "</a>";
                                $news_html .= "<div class='post-bottom'>";
                                    $news_html .= "<div class='post-author-box'>";
                                        $news_html .= "<span class='author-avatar'><img alt='avatar' src='/public_html/assets/images/avatar.jpg' class='avatar' height='24' width='24'></span>";
                                        $news_html .= "<a href='#' class='author-name'>".$post['created_by']."</a>";
                                        $news_html .= "<span class='post-date'>".date(DEFAULT_DATETIME_FORMAT,$post['date_created'])."</span>";
                                    $news_html .= "</div>";
                                    $news_html .= "<div class='post-meta'>";
                                        $news_html .= "<a href='". site_url()."news/view/".$post['rand_id']."' class='read-more'>".lang('read_more')."<i class='material-icons'>&#xE315;</i></a>";
                                    $news_html .= "</div>";
                                $news_html .= "</div>";
                            $news_html .= "</div>";
                        $news_html .= "</div>";
                    }
                }
                else{
                    $news_html .= "<div class='col-md-12'>";                    
                        $news_html .= "<p>". lang('no_post_found')."</p>";
                    $news_html .= "</div>";
                }
                
                $return = array('status'=>TRUE,'latest_news'=> $latest_news_html,'news'=>$news_html);
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
    public function change_news_home_slider_status_post()
    {

        try {
            if($this->input->post('id')){

                    $where = array(); 
                    $where['news_id'] = $this->input->post('id');
                   
                    $c_data = array();
                    $c_data['add_to_home_slider'] = $this->input->post('val');
                    $c_data['date_modified'] = now();
                    $c_data['user_modified'] = $this->session->userdata('ds_user');

                    $res = $this->news_model->update_news_details($this->_news_table,$c_data, $where);
                    
                    if($res){

                        $this->log_model->add('info', "News home slider status updated successfully, News ID(".$res.")");
                        $return = array('status'=>TRUE,'message'=>lang('news_status_updated_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('news_status_could_not_be_updated'));
                        $this->log_model->add('error', "News status could not be updated.");
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
    public function save_bookmark_post()
    {

        try {
            if($this->session->userdata('normal_user')){
                 if($this->input->post('entity')&&$this->input->post('entity_id')){
    
                    $data = array();
                    $data['entity'] = $this->input->post('entity');
                    $data['entity_id'] = $this->input->post('entity_id');
                    $data['user_id'] = $this->session->userdata('normal_user');
                    $data['date_created'] = now();
    
                    $res = $this->news_model->save_bookmark($this->_bookmark_table,$data);
                    
                    if($res){
    
                        $this->log_model->add('info', "Bookmark saved successfully, Entity(" . $this->input->post('entity') . "), Entity ID(".$this->input->post('entity_id').")");
                        $return = array('status'=>TRUE,'message'=>lang('bookmark_saved_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('bookmark_cound_not_saved'));
                        $this->log_model->add('error', "Bookmark could not be updated.");
                    }
                    $this->response($return, 200);
                    
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->response($return, 200);
                }
            }
            else{
                $return = array('status'=>FALSE,'message'=>lang('please_login_to_bookmark_this_news_post'),"next"=>site_url()."login");
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
    public function delete_bookmark_post()
    {

        try {
            if($this->session->userdata('normal_user')){
                 if($this->input->post('entity')&&$this->input->post('entity_id')){
    
                    $data = array();
                    $data['entity'] = $this->input->post('entity');
                    $data['entity_id'] = $this->input->post('entity_id');
                    $data['user_id'] = $this->session->userdata('normal_user');
                    
                    $res = $this->news_model->delete_bookmark($this->_bookmark_table,$data);
                    
                    if($res){
    
                        $this->log_model->add('info', "Bookmark deleted successfully, Entity(" . $this->input->post('entity') . "), Entity ID(".$this->input->post('entity_id').")");
                        $return = array('status'=>TRUE,'message'=>lang('bookmark_removed_successfully'));
                        
                    }
                    else{
                        $return = array('status'=>FALSE,'message'=>lang('bookmark_cound_not_deleted'));
                        $this->log_model->add('error', "Bookmark could not be deleted.");
                    }
                    $this->response($return, 200);
                    
                }
                else{
                    $return = array('status'=>FALSE,'message'=>lang('msg_something_went_wrong'));
                    $this->response($return, 200);
                }
            }
            else{
                $return = array('status'=>FALSE,'message'=>lang('please_login_to_bookmark_this_news_post'),"next"=>site_url()."login");
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
