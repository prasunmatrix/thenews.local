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
        <meta name="description" content="">
        <?php
            $keywords = "";
//            $k = json_decode($about_us_details[0]['seo_keywords']);
//            if(!empty($k)){
//                foreach($k as $key){
//                    if($keywords==""){
//                        $keywords = $key->text;
//                    }
//                    else{
//                        $keywords .= "|".$key->text;
//                    }                
//                }
//            }
        ?>
        <meta name="keywords" content="<?= $keywords; ?>">
        <meta name="author" content=".com">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="">
        <meta name="twitter:description"  content="">
        <meta name="twitter:image"        content="">
        <meta name="twitter:card"         content=".com">        
        <meta property="og:url"           content="<?= site_url(); ?>about_us" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="" />
        <meta property="og:description"   content="" />
        <meta property="og:image"         content="" />
        <meta property="og:site_name"     content=".com">     
        <meta property="article:published_time" content="" />
        <meta property="article:modified_time" content="" />
        <meta property="article:section" content="" />
        <meta property="article:tag" content="<?= $keywords ?>" />
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
                            <div class="col-md-12">
                                <center>
                                <a href="<?= site_url() ?>district/view/district-north" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_1'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-south" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_2'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-gomati" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_3'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-sepahijla" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_4'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-unakati" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_5'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-west" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_6'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-khowei" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_7'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-dhalai" class="btn btn-default btn-xs" style="font-size: 14px;"><?= lang('district_8'); ?></a>
                                </center>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <p class="text-center"><?= lang('please_select_a_district_to_view_news'); ?></p>
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