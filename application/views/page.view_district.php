<?php
    $this->load->view('_head.php');
?>
        <title><?= $page_title . " - " . SITE_TITLE; ?></title>
        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
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
        <style>
            .btn-active{
                background: #1c1c1c;
                color: #fff;
            }
        </style>
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
                        <div class="col-md-12">
                            <center>
                                <a href="<?= site_url() ?>district/view/district-north" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-north") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_1'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-south" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-south") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_2'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-gomati" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-gomati") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_3'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-sepahijla" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-sepahijla") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_4'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-unakati" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-unakati") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_5'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-west" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-west") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_6'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-khowei" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-khowei") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_7'); ?></a>
                                <a href="<?= site_url() ?>district/view/district-dhalai" class="btn btn-default btn-xs <?php if($this->uri->segment(4)=="district-dhalai") { echo "btn-active"; }?>" style="font-size: 14px;"><?= lang('district_8'); ?></a>
                            </center>
                            </div>
                            <div class="col-md-12">
                                <hr>
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