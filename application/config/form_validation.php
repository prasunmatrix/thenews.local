<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This config file contains all form validation rules for all forms in the web application.
 */

$config = array(
    'user_social_login' => array(
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'required|valid_email',            
        ),
        array(
            'field' => 'oauth_provider',
            'label' => 'lang:oauth_provider',
            'rules' => 'required',            
        ),
        array(
            'field' => 'oauth_id',
            'label' => 'lang:oauth_id',
            'rules' => 'required',            
        ),
        array(
            'field' => 'full_name',
            'label' => 'lang:full_name',
            'rules' => 'required',            
        ),
    ),
    'forgot_password' => array(
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'required|valid_email',            
        ),
    ),
    'user_login' => array(
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'required|valid_email',            
        ),
        array(
            'field' => 'password',
            'label' => 'lang:password',
            'rules' => 'required',            
        ),
    ),
    'change_password' => array(
        array(
            'field' => 'old_password',
            'label' => 'lang:current_password',
            'rules' => 'required',            
        ),
        array(
            'field' => 'new_password',
            'label' => 'lang:new_password',
            'rules' => 'required',            
        ),
        array(
            'field' => 'c_new_password',
            'label' => 'lang:c_new_password',
            'rules' => 'required|matches[new_password]',            
        ),
    ),
    'reset_password' => array(
        array(
            'field' => 'password',
            'label' => 'lang:password',
            'rules' => 'required',            
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'lang:confirm_password',
            'rules' => 'required|matches[password]',            
        ),
    ),
    'save_news_types' => array(
        array(
            'field' => 'news_type_title',
            'label' => 'lang:news_type_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'news_type_url',
            'label' => 'lang:news_type_url',
            'rules' => 'required',            
        ),
    ),
    'save_news_details' => array(
        array(
            'field' => 'news_title',
            'label' => 'lang:news_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'news_url',
            'label' => 'lang:news_url',
            'rules' => 'required',            
        ),
        array(
            'field' => 'news_type',
            'label' => 'lang:news_type',
            'rules' => 'required',            
        ),
        array(
            'field' => 'topics[]',
            'label' => 'lang:topics',
            'rules' => 'required',            
        ),
    ),
    'save_live_news_details' => array(
        array(
            'field' => 'news_title',
            'label' => 'lang:news_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'news_url',
            'label' => 'lang:news_url',
            'rules' => 'required',            
        ),
    ),
    'save_video_details' => array(
        array(
            'field' => 'video_title',
            'label' => 'lang:video_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'video_url',
            'label' => 'lang:video_url',
            'rules' => 'required',            
        ),
        array(
            'field' => 'yt_video_url',
            'label' => 'lang:yt_video_url',
            'rules' => 'required',            
        ),
    ),
    'save_exclusive_news_details' => array(
        array(
            'field' => 'news_title',
            'label' => 'lang:news_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'news_url',
            'label' => 'lang:news_url',
            'rules' => 'required',            
        ),
    ),
    'save_topic_details' => array(
        array(
            'field' => 'topic_name',
            'label' => 'lang:topic_name',
            'rules' => 'required',            
        ),
        array(
            'field' => 'topic_url',
            'label' => 'lang:topic_url',
            'rules' => 'required',            
        ),
    ),
    'save_menu_item_details' => array(
        array(
            'field' => 'item_title',
            'label' => 'lang:item_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'item_url',
            'label' => 'lang:item_url',
            'rules' => 'required',            
        ),
    ),
    'save_menu_sub_item_details' => array(
        array(
            'field' => 'sub_item_title',
            'label' => 'lang:sub_item_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'sub_item_url',
            'label' => 'lang:sub_item_url',
            'rules' => 'required',            
        ),
        array(
            'field' => 'parent_item_id',
            'label' => 'lang:parent_item_id',
            'rules' => 'required',            
        ),
    ),
    'save_adsense_details' => array(
        array(
            'field' => 'adsense_code',
            'label' => 'lang:google_ad_client',
            'rules' => 'required',            
        ),
    ),
    'save_analytics_details' => array(
        array(
            'field' => 'tracking_id',
            'label' => 'lang:tracking_id',
            'rules' => 'required',            
        ),
    ),
    'save_date_format_details' => array(
        array(
            'field' => 'date_format',
            'label' => 'lang:date_format',
            'rules' => 'required',            
        ),
        array(
            'field' => 'time_format',
            'label' => 'lang:time_format',
            'rules' => 'required',            
        ),
    ),
    'save_email_signature_details' => array(
        array(
            'field' => 'email_signature',
            'label' => 'lang:email_signature',
            'rules' => 'required',            
        ),
    ),
    'save_epaper_details' => array(
        array(
            'field' => 'epaper_title',
            'label' => 'lang:epaper_title',
            'rules' => 'required',            
        ),
        array(
            'field' => 'epaper_date',
            'label' => 'lang:epaper_date',
            'rules' => 'required',            
        ),
    ),
    'save_user_details' => array(
        array(
            'field' => 'full_name',
            'label' => 'lang:full_name',
            'rules' => 'required',            
        ),
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'required|is_unique[users.email]',            
        ),
        array(
            'field' => 'password',
            'label' => 'lang:password',
            'rules' => 'required',            
        ),
    ),
);
