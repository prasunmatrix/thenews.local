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
    <body>
        <!--************************************
            Loader Start
        *************************************-->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!--************************************
            Loader End
        *************************************-->
        
        <?php
            $this->load->view('block.head.php');
        ?>
        
        <!--************************************
            Blog Post Start
        *************************************-->
        <main id="tg-main" class="tg-main tg-haslayout">
            <div class="container-fluid">
                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo tg-bglight" style="padding-top: 120px;">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3 class="text-center"><?= lang('live_news'); ?></h3>
                            <div class="grid-sizer"></div>
                            <?php
                                if(!empty($live_news)){
                                    foreach($live_news as $post){
                            ?>
                                <div class="tg-post tg-masonrygrid">
                                    
                                        <?php
                                            if($post['s_thumbnail']!=""){
                                        ?>
                                        <figure>
                                            <a href="<?= site_url() ?>live_news/view/<?= $post['rand_id']; ?>"><img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $post['s_thumbnail']; ?>" alt="image description"></a>
                                        </figure>
                                        <?php
                                            }
                                        ?>
                                    <div class="tg-postcontent">
                                        <div class="tg-posttitle">
                                            <h3><a href="<?= site_url() ?>live_news/view/<?= $post['rand_id']; ?>"><?= $post['news_title']; ?></a></h3>
                                        </div>
                                        <div class="tg-description">
                                            <p><?= mb_strimwidth($post['news_desc'], 0, 97, '...'); ?></p>
                                        </div>
                                        <ul class="tg-postmetadata">
                                            <li><time datetime="<?= date('Y-m-d',$post['date_created']); ?>"><?= date($configs['date_format'],$post['date_created']); ?></time></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                                else{
                                    echo lang('no_news_found');
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--************************************
            Blog Post End
        *************************************-->
        <?php
            $this->load->view('block.foot.php');
        ?>