<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view('_head.php');
?>

        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title><?= $page_title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index, follow">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="">
        <meta name="twitter:description"  content="">
        <meta name="twitter:image"        content="/public_html/images/site-logo.png">
        <meta name="twitter:card"         content="">        
        <meta property="og:url"           content="<?= site_url(); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="" />
        <meta property="og:description"   content="" />
        <meta property="og:image"         content="/public_html/images/site-logo.png" />
        <meta property="og:site_name"     content="">     
        <meta property="article:published_time" content="" />
        <meta property="article:modified_time" content="" />
        <meta property="article:section" content="" />
        <meta property="article:tag" content="" />
    </head>
    <body data-gr-c-s-loaded="true" class="js-focus-visible">

            <?php
            $this->load->view('block.head.php');
            ?>

            <main class="main-container">
                <!--************************************
                                Blog Detail Start
                *************************************-->
                <div id="tg-content" class="tg-content">
                    <div class="tg-blogpost tg-blogdetailvfour">
                        <div class="tg-sectionspace tg-haslayout" style="padding-bottom: 0px ;">
                            <div class="container">
                                
                                <div class="row">
                                    <?php
                                        if(!empty($videos)){
                                            foreach($videos as $video){
                                    ?>
                                    <div class="col-md-6" style="margin-bottom: 40px;">
                                        <a href="<?= site_url(); ?>videos/view/<?= $video['rand_id']; ?>">
                                            <?php
                                                if($video['s_thumbnail']!=""){
                                            ?>
                                            <img src="<?= S3_URL.S3_BUCKET_NAME?>/images/<?= $video['s_thumbnail']; ?>" class="img-responsive video_thumbnail"/>
                                            <?php
                                                }
                                                else{
                                            ?>
                                            <img src="/public_html/images/play-button.png" class="img-responsive video_thumbnail"/>
                                            <?php
                                                }
                                            ?>
                                            <h4 class="text-center margin-top-15"><?= $video['video_title']; ?></h4>
                                        </a>
                                    </div>
                                    <?php
                                            }
                                        }
                                        else{
                                    ?>
                                    <p class="text-center"><?= lang('no_video_found'); ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--************************************
                                                Blog Detail End
                *************************************-->
            </main>

    <?php
    $this->load->view('block.foot.php');
    ?>