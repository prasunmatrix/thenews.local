<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Files API
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
 *     resourcePath="/blgs",
 *     basePath="http://vrpatel.in/en/api",
 *     description="Operations on files"
 * )
 */

require (APPPATH.'libraries/REST_Controller.php');

/**
 * Class Files
 *
 */
class Files extends REST_Controller {

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
        $config = array();
        $config['image_library'] = 'gd2';
        $this->load->library('image_lib',$config);
    }

    
    /**
     * @var string what table is used in the database for the users
     */
    public $_general_config_table= 'general_config';
    
    /**
     * Upload an Image POST
     *
     * Responds with information about uploaded file
     *
     * @return string Data with upload file path
     */
    public function upload_image_post()
    {
        //set upload file configuration
        
//        $config['upload_path']          = './public_html/upload/images';
//        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
//        $config['max_size']             = 25000;
//
//        // get file extension
//        $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
//
//        // change file name
//        $_FILES['file']['name'] = sha1(microtime()) . "." .$file_ext;
//        
//        //load library
//        $this->load->library('upload', $config);
//
//        if ( ! $this->upload->do_upload('file'))
//        {
//                $result = array('error' => $this->upload->display_errors());
//        }
//        else
//        {
//                $data = array('upload_data' => $this->upload->data());               
//                $result = array('link'=> base_url().'public_html/upload/images/'.$data['upload_data']['file_name']);
//        }
//        $this->response($result, 200);
//        

        $config['upload_path'] = './public_html/upload/images';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
        $config['max_size'] = 25000;

        $image_sizes = array(
            'large' => array(1250, 1250),
            'small' => array(850, 850),
        );

        // get file extension
        $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        // change file name
        $_FILES['file']['name'] = sha1(microtime()) . "." . $file_ext;

        //load library
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
            $this->response($return, 200);
        } else {

            $img_data = array('upload_data' => $this->upload->data());
            $uploaded_image = $img_data['upload_data']['file_name'];

            //load album watermark settings
            $watermark_settings = $this->users_model->get_where($this->_general_config_table,array('deleted'=>'0'));

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
                if($config['config_name']=='watermark_in_text_editor'){
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
                }
                else if($key=='small'){
                    $large_thumb_img_name = sha1(microtime()) . "." . $file_ext;
                    $small_image_link = $large_thumb_img_name;
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
            
            $result = array('link'=> S3_URL.S3_BUCKET_NAME.'/images/'.$small_image_link,'url'=> S3_URL.S3_BUCKET_NAME.'/images/'.$large_image_link,'thumb'=> S3_URL.S3_BUCKET_NAME.'/images/'.$large_image_link);
            
            $this->response($result, 200);
        }
                        
    }   
    
    
    /**
     * Upload Video POST
     *
     * Responds with information about uploaded video
     *
     * @return string Data with upload video path
     */
    public function upload_video_post()
    {
        //set upload video configuration
        
        $config['upload_path']          = './public_html/upload/videos';
        $config['allowed_types']        = 'mp4|avi|mkv|3gp|gif|flv|';
        $config['max_size']             = 1500000;

        // get file extension
        $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        // change file name
        $_FILES['file']['name'] = sha1(microtime()) . "." .$file_ext;
        
        //load library
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
                $result = array('error' => $this->upload->display_errors());
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());               
                $result = array('link'=> base_url().'public_html/upload/videos/'.$data['upload_data']['file_name']);
        }
        $this->response($result, 200);
    }    
    /**
     * Upload File POST
     *
     * Responds with information about uploaded file
     *
     * @return string Data with upload file path
     */
    public function upload_file_post()
    {
        //set upload file configuration
        
        $config['upload_path']          = './public_html/upload/documents';
        $config['allowed_types']        = 'pdf|doc|docx|ppt|xls|xlxs';
        $config['max_size']             = 100000;

        // get file extension
        $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        // change file name
        $_FILES['file']['name'] = sha1(microtime()) . "." .$file_ext;
        
        //load library
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
                $result = array('error' => $this->upload->display_errors());
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());               
                $result = array('link'=> base_url().'public_html/upload/documents/'.$data['upload_data']['file_name']);
        }
        $this->response($result, 200);
    }    
}
