<?php
    if($this->session->userdata('normal_user')){
        $profile_details = $this->log_model->get_where("users",array('user_id'=>$this->session->userdata('normal_user')));
        if(!empty($profile_details)){
            $this->session->set_userdata('normal_subscribed_plan', $profile_details[0]['subscribed_plan_id']);
            $this->session->set_userdata('normal_subscription_end_date', $profile_details[0]['subscription_end_date']);
        }
    }
    else{
        if(isset($_COOKIE['loggedin_user_id'])){
            $this->session->set_userdata('normal_user', $_COOKIE['loggedin_user_id']);
            $profile_details = $this->log_model->get_where("users",array('user_id'=>$this->session->userdata('normal_user')));
            if(!empty($profile_details)){
                $this->session->set_userdata('normal_subscribed_plan', $profile_details[0]['subscribed_plan_id']);
                $this->session->set_userdata('normal_subscription_end_date', $profile_details[0]['subscription_end_date']);
            }
        }
    }
    $this->load->view('page.stat.php');
    
    
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="/public_html/pwa/manifest.json" />
        <link rel="apple-touch-icon" href="/public_html/apple-touch-icon.png?v=<?= RELEASE_VERSION; ?>">
        <link rel="icon" href="/public_html/images/favicon.ico?v=<?= RELEASE_VERSION; ?>" type="image/x-icon">
        <link href="/public_html/css/style.css?v=<?= RELEASE_VERSION; ?>" rel="stylesheet">
        <link rel="stylesheet" href="/public_html/css/bootstrap.min.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/normalize.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/icomoon.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/owl.carousel.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/scrollbar.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/prettyPhoto.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/transitions.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/royalslider.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/main.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/color.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/responsive.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/responsive.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/fontawesome/css/all.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/lightbox.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" href="/public_html/css/bootstrap-datepicker.min.css?v=<?= RELEASE_VERSION; ?>">
        <link rel="stylesheet" type="text/css" href="/public_html/css/alertify.min.css?v=<?= RELEASE_VERSION; ?>">
        <script src="/public_html/js/jquery-3.6.0.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/lightbox.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/bootstrap-datepicker.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script type="text/javascript" src="/public_html/js/alertify.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>        
        <style>
            @font-face {
                font-family: 'prothomaregular';
                src: url('/public_html/fonts/prothoma/prothoma-webfont.woff2') format('woff2'),
                     url('/public_html/fonts/prothoma/prothoma-webfont.woff') format('woff');
                font-weight: normal;
                font-style: normal;
            
            }
            h1, h2, h3, h4, h5, h6, p, a{
            	font-family: 'prothomaregular';
            }
        </style>
