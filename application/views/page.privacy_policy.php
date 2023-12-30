<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view('_head.php');
?>

        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title><?= $page_title; ?></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>">
        <?php
            $keywords = "";
            $k = json_decode($about_us_details[0]['seo_keywords']);
            if(!empty($k)){
                foreach($k as $key){
                    if($keywords==""){
                        $keywords = $key->text;
                    }
                    else{
                        $keywords .= "|".$key->text;
                    }                
                }
            }
        ?>
        <meta name="keywords" content="<?= $keywords; ?>">
        <meta name="author" content=".com">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title']));; ?>">
        <meta name="twitter:description"  content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>">
        <meta name="twitter:image"        content="">
        <meta name="twitter:card"         content=".com">        
        <meta property="og:url"           content="<?= site_url(); ?>privacy_policy" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title'])); ?>" />
        <meta property="og:description"   content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>" />
        <meta property="og:image"         content="" />
        <meta property="og:site_name"     content=".com">     
        <meta property="article:published_time" content="<?= date('Y-m-d\TH:m:sP',$about_us_details[0]['date_created']); ?>" />
        <meta property="article:modified_time" content="<?= date('Y-m-d\TH:m:sP',$about_us_details[0]['date_modified']); ?>" />
        <meta property="article:section" content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title'])); ?>" />
        <meta property="article:tag" content="<?= $keywords ?>" />
        <style>
            p{
                font-family: auto;
            }
        </style>
    </head>
    <body data-gr-c-s-loaded="true" class="js-focus-visible">

            <?php
            $this->load->view('block.head.php');
            ?>
        <main id="tg-main" class="tg-main tg-haslayout">
            <!--************************************
                            About Us Start
            *************************************-->
            <section class="tg-sectionspace tg-haslayout tg-paddingbottomzero">
                <div class="container">
                    <div class="row">
                        <div class="tg-aboutus tg-aboutusvtwo tg-aboutcreative">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <h2><?= lang('privacy_policy'); ?></h2>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <div class="tg-description">
                                    <?php
                                        if(isset($about_us_details[0]['privacy_and_policy'])){
                                            if($about_us_details[0]['privacy_and_policy']!="<p><br></p>"){
                                                echo $about_us_details[0]['privacy_and_policy'];
                                            }
                                            else{
                                                echo lang('not_available');
                                            }
                                        }
                                        else{
                                            echo lang('not_available');
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--************************************
                            About Us End
            *************************************-->
        </main>

    <?php
    $this->load->view('block.foot.php');
    ?>