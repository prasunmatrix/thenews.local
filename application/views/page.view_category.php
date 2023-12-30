<?php
    $this->load->view('_head.php');
?>
        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title><?= $page_title . " - " . SITE_TITLE; ?></title>
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

        <section class="tg-sectionspace tg-haslayout" style="padding-bottom: 50px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-lg-push-2 col-lg-8">
                            <div class="tg-sectionhead tg-sectionheadvtwo">
                                <div class="tg-sectiontitle">
                                    <h2><?= $news_type_details[0]['news_type_title']; ?></h2>
                                </div>
                                <?php
                                    if($news_type_details[0]['news_type_desc']!="<p><br></p>"){
                                ?>
                                <div class="tg-description">
                                    <?= $news_type_details[0]['news_type_desc']; ?>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="tg-filtermasonryvone" class="tg-filtermasonry">
                                <div class="grid-sizer"></div>
                                
                                <?php
                                    if(!empty($news_posts)){
                                        foreach($news_posts as $post){
                                ?>
                                
                                <div class="tg-post tg-masonrygrid">
                                    <figure>
                                        <?php
                                            if($post['s_thumbnail']!=""){
                                        ?>
                                            <a href="<?= site_url() ?>news/view/<?= $post['rand_id']; ?>"><img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $post['s_thumbnail']; ?>" alt="image description"></a>
                                        <?php
                                            }
                                            else{
                                        ?>
                                        <a href="<?= site_url() ?>news/view/<?= $post['rand_id']; ?>"><img src="/public_html/images/thumbnail.png" alt="image description"></a>
                                        <?php        
                                            }
                                        ?>
                                        <a href="<?= site_url() ?>category/view/<?= $post['news_type_rand_id']; ?>"><span class="tg-postcategory"><?= $post['news_type_title']; ?></span></a>
                                    </figure>
                                    <div class="tg-postcontent">
                                        <div class="tg-posttitle">
                                            <h3><a href="<?= site_url() ?>news/view/<?= $post['rand_id']; ?>"><?= $post['news_title']; ?></a></h3>
                                        </div>
                                        <div class="tg-description">
                                            <p><?= mb_strimwidth(strip_tags($post['news_desc']), 0, 97, '...'); ?></p>
                                        </div>
                                        <ul class="tg-postmetadata">
                                            <li>
                                                <span><a href="<?= site_url() ?>category/view/<?= $post['news_type_rand_id']; ?>"><?= $post['news_type_title']; ?></a></span>
                                            </li>
                                            <li><time datetime="<?= date('Y-m-d',$post['date_created']); ?>"><?= date($configs['date_format'],$post['date_created']); ?></time></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <?php       
                                        }
                                    }
                                    else{
                                        echo "<p class='text-center'>" . lang('no_news_post_found') . "</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            $this->load->view('block.foot.php');
        ?>