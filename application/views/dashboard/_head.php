<?php
    $general_config = $this->users_model->get_where('general_config',array('deleted'=>'0'));
    $configs = array();
    if(!empty($general_config)){
        foreach($general_config as $config){
            $configs[$config['config_name']] = $config['config_value'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="app">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/froala_editor.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/froala_style.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/code_view.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/draggable.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/colors.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/emoticons.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/image_manager.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/image.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/line_breaker.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/table.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/char_counter.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/video.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/fullscreen.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/file.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/quick_insert.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/help.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/third_party/spell_checker.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/plugins/special_characters.css">
        <link rel="stylesheet" type="text/css" href="/public_html/editor/css/codemirror.min.css">        
        <link rel="stylesheet" type="text/css" href="/public_html/css/alertify.min.css">
        <link rel="stylesheet" type="text/css" href="/public_html/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/css/animate.css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/css/font.css"/>
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/js/datatables/datatables.css"/>
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/js/calendar/bootstrap_calendar.css"/>
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/css/app.css"/>    
        <link rel="stylesheet" type="text/css" href="/public_html/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="/public_html/css/bootstrap-clockpicker.min.css">
        <link rel="stylesheet" type="text/css" href="/public_html/css/dropzone.css">
        <link rel="stylesheet" type="text/css" href="/public_html/css/lightbox.css">
        <link rel="stylesheet" type="text/css" href="/public_html/js/fuelux/fuelux.css">
        <link rel="stylesheet" type="text/css" href="/public_html/dashboard/js/intro/introjs.css">
        <link rel="stylesheet" type="text/css" href="/public_html/css/style.css">        
        <script type="text/javascript" src="/public_html/js/jquery.min.js"></script>
        <!--<script type="text/javascript" src="/public_html/js/jquery-2.2.3.min.js"></script>-->
        <script type="text/javascript" src="/public_html/js/select2.min.js"></script>
        <script type="text/javascript" src="/public_html/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="/public_html/js/bootstrap-clockpicker.min.js"></script>
        <script type="text/javascript" src="/public_html/js/dropzone.js"></script>
        <script type="text/javascript" src="/public_html/js/lightbox.js"></script>        
        <script type="text/javascript" src="/public_html/js/fuelux/fuelux.js"></script>        
