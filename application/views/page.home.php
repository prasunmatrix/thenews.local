<?php
    $this->load->view('_head.php');
?>
        
        <title>Pratibadi Kalam | প্রতিবাদী কলম</title>
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
        <main id="tg-main" style="margin-top: 60px;" class="tg-main tg-haslayout">
            <div class="container-fluid">
                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo tg-bglight">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <div id="tg-filtermasonryvone" class="tg-filtermasonry">
                                <div class="grid-sizer"></div>
                                
                                <?php
                                    if(!empty($first_page_news_posts)){
                                        $count = 0;
                                        foreach($first_page_news_posts as $post){
                                            $count++;
                                            if($count<6){
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
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo tg-bglight">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <div id="tg-filtermasonryvone" class="tg-filtermasonry">
                                <div class="grid-sizer"></div>
                                
                                <?php
                                    if(!empty($news_posts)){
                                        $count = 0;
                                        foreach($news_posts as $post){
                                            $count++;
                                            if($count<6){
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
                                            <p><?= mb_strimwidth($post['news_desc'], 0, 97, '...'); ?></p>
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
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!--************************************
                        News & Update Start
                    *************************************-->
                <?php
                    
                    if(!empty($live_news_posts)){
                        $bg = "/public_html/images/exclusive_news_bg.jpg";
                        if($live_news_posts[0]['thumbnail']!=""){
                            $bg = S3_URL.S3_BUCKET_NAME."/images/" . $live_news_posts[0]['thumbnail'];
                        }
                ?>
                <section class="tg-haslayout" data-z-index="2" data-appear-top-offset="600" data-parallax="scroll"
                         data-image-src="<?= $bg; ?>">
                    <div class="tg-sectionspace tg-parallax tg-parallaxnewsupdate">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="tg-newsupdates">
                                        <div class="tg-sectionhead tg-sectionheadvtwo">
                                            <div class="tg-sectiontitle">
                                                <h2><?= lang('live_news'); ?></h2>
                                            </div>
                                            <div class="tg-description">
                                                <p><?= $live_news_posts[0]['news_desc']; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                            $total_news = 0;
                                            if(!empty($live_news_posts)){
                                                $total_news = count($live_news_posts);
                                            }
                                        ?>
                                        <h3><span><?= $total_news; ?></span><?= lang('total_news_feeds'); ?></h3>
                                        <a class="tg-btnviewallpost" href="<?= site_url() ?>live_news/"><?= lang('go_to_live_page'); ?></a>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-8 col-lg-8">
                                    <div id="tg-postsslider" class="tg-postsslider owl-carousel tg-posts">
                                        <?php
                                            if(!empty($live_news_posts)){
                                                foreach($live_news_posts as $post){
                                        ?>
                                        <div class="item">
                                            <article class="tg-post">
                                                <div class="tg-posttitle">
                                                    <h3><a href="<?= site_url() ?>live_news/view/<?= $live_news_posts[0]['rand_id']; ?>"><?= $post['news_title']; ?> </a></h3>
                                                </div>
                                                <div class="tg-description">
                                                    <p><?= mb_strimwidth($post['news_desc'], 0, 250, '...'); ?></p>
                                                </div>
                                                <ul class="tg-postmetadata">
                                                    <li>
                                                        <figure>
                                                            <?php
                                                                $author_img_src = "";
                                                                if($post['user_avatar']!=""){
                                                                    $author_img_src = S3_URL.S3_BUCKET_NAME . "/images/" . $post['user_avatar'];
                                                                }
                                                                else{
                                                                    $author_img_src = "/public_html/images/user.png";
                                                                }
                                                            ?>
                                                            <a href="">
                                                                <img src="<?= $author_img_src; ?>" alt="image description" class="author-avatar-small">
                                                            </a>
                                                        </figure>
                                                        <span>By <a href="#"><?= $post['created_by']; ?></a></span>
                                                    </li>
                                                    <li><time datetime="2017-07-07"><?= date($configs['date_format'],$post['date_created']); ?></time></li>
                                                </ul>
                                            </article>
                                        </div>
                                        <?php
                                                }
                                            }
                                            else{
                                                echo "no post found";
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                    }
                ?>
                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo tg-bglight">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <div>
                                <div class="grid-sizer"></div>
                                
                                <?php
                                    if(!empty($news_posts)){
                                        $count = 0;
                                        foreach($news_posts as $news){
                                            $count++;
                                                $html = "";
                                                 $html .= "<div class='col-xs-6 col-sm-6 col-md-4' style='border: 1px solid #e7e7e7; border-left: 0px; padding-bottom: 5px;padding-top: 20px;padding-left:0px;padding-right:0px;'>";
                                                $html .= "<div class='col-sm-3' style='overflow:hidden;' >";
                                                    $html .= "<center><a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>";
                                                        if($news['l_thumbnail']!=""){
                                                            $html .= "<img style='transform: scale(1.5); transform-origin: center;' src='" . S3_URL . S3_BUCKET_NAME . "/images/" . $news['l_thumbnail'] . "' alt='".$news['seo_title']."' title='".$news['seo_title']."' class='home_page_2_column_news'></a></center>";
                                                        }
                                                        else{
                                                            $html .= "<img style='transform: scale(1.5); transform-origin: center;' src='/public_html/images/thumbnail.png' alt='".$news['seo_title']."' title='".$news['seo_title']."' class='home_page_2_column_news'></a></center>";
                                                        }
                                                $html .= "</div>";
                                                $html .= "<div class='col-sm-9'>";
                                                    $html .= "<div>";
                                                        $html .= "<h3 style='font-size:15px;margin-top:8px;'><a href='" . site_url() . "news/view/" . $news['rand_id'] . "'>" . mb_strimwidth($news['news_title'], 0, 30, '...') . "</a></h3>";
                                                    $html .= "</div>";
                                                    $html .= "<ul class='tg-postmetadata'>";
                                                        $html .= "<li>";
                                                            $html .= "<span><a href='" . site_url() . "category/view/" . $news['news_type_rand_id'] . "'>".$news['news_type_title']."</a></span>";
                                                        $html .= "</li>";
                                                        $html .= "<li><time datetime='".date('Y-m-d',$news['date_created'])."'>".date($this->configs['date_format'],$news['date_created'])."</time></li>";
                                                    $html .= "</ul>";
                                                $html .= "</div>";
                                            $html .= "</div>";
                                            echo $html;
                                 
                                            
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--************************************
                    News & Update End
                *************************************-->
                <!--************************************
                                                            Services V Three Start
                            *************************************-->
                <section class="tg-sectionspace tg-overlapcontent tg-paddingbottomzero tg-bgwhite tg-haslayout">
                    <div class="container">
                        <div class="row">
                            <div class="tg-services tg-servicesvthree">
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                    <div class="tg-video">
                                        <!--************************************
                                            Home Slider Five Start
                                        *************************************-->
                                        <div id="tg-homeslidervfive" class="tg-homeslider owl-carousel tg-homeslidervfive">
                                            <?php
                                                if(!empty($all_categories)){
                                                    foreach($all_categories as $cat){
                                                        $img = "";
                                                        if($cat['thumbnail']!=""){
                                                            $img = "/public_html/upload/images/" . $cat['thumbnail'];
                                                        }
                                                        else{
                                                            $img = "/public_html/images/sample1.jpg";
                                                        }
                                            ?>
                                            <a href="<?= site_url() ?>category/view/<?= $cat['rand_id']; ?>">
                                                <figure class="item" data-vide-bg="poster: <?= $img; ?>" data-vide-options="position: 0% 50%">
                                                    <figcaption>
                                                        <div class="tg-slidercontent">
                                                            <div class="tg-description">
                                                                <p><?= $cat['news_type_title']; ?></p>
                                                            </div>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </a>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <!--************************************
                                            Home Slider Five End
                                        *************************************-->
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="row">
                                        <div class="tg-service">
                                            <div class="tg-themetabs tg-servicestabs">
                                                <ul class="tg-themetabnav" role="tablist">
                                                    <?php
                                                        if(!empty($categories)){
                                                            $count = 0;
                                                            foreach ($categories as $cat){
                                                                $count++;
                                                                if($count==1){
                                                                    $class_name = "active";
                                                                }
                                                                else{
                                                                    $class_name = "";
                                                                }
                                                    ?>
                                                        <li role="presentation" class="<?= $class_name; ?>">
                                                            <a href="#<?= $cat['rand_id']; ?>" aria-controls="perfectdesign" role="tab" data-toggle="tab"><?= $cat['news_type_title']; ?></a>
                                                        </li>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <div class="tab-content tg-themetabcontent">
                                                    <?php
                                                        if(!empty($categories)){
                                                            $count = 0;
                                                            foreach ($categories as $cat){
                                                                $count++;
                                                                if($count==1){
                                                                    $class_name = "active";
                                                                }
                                                                else{
                                                                    $class_name = "";
                                                                }
                                                    ?>
                                                    <div role="tabpanel" class="tab-pane <?= $class_name?>" id="<?= $cat['rand_id']; ?>">
                                                        <?php
                                                            if($cat['news_type_desc']!="<p><br></p>"){
                                                        ?>
                                                        <div class="tg-description">
                                                            <p><?= $cat['news_type_desc']; ?></p>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        <ul>
                                                        <?php
                                                            if(!empty($category_news_posts)){
                                                                foreach($category_news_posts as $cat_key=>$cat_posts){
                                                                    if($cat_key==$cat['news_type_id']){
                                                                        if(!empty($cat_posts)){
                                                                            foreach ($cat_posts as $post){
                                                        ?>
                                                            <li><a href="<?= site_url() ?>news/view/<?= $post['rand_id']; ?>" style="color:#000;"><i class="fa fa-circle"></i> &nbsp;<?= $post['news_title']; ?></a></li>
                                                        <?php                        
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                        </ul>
                                                    </div>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--************************************
                    Services V Three End
                *************************************-->
                    
            </div>
            <main id="tg-main" class="tg-main tg-haslayout tg-bgdarkvtwo">
                <section class="tg-sectionspace tg-whitecontent tg-haslayout" style="padding: 40px 0px;">
                    <div class="container">
                        <div class="row">
                            <div class="tg-processcontent">
                                <div class="tg-sectionhead tg-sectionheadvtwo" style="padding-bottom: 0px;">
                                    <div class="tg-sectiontitle text-center">
                                        <h2 style="color: #fff;line-height:42px;"><?= lang('videos'); ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="tg-portfolioholder">
                                <div id="tg-portfoliovthree" class="tg-portfolio tg-portfoliovthree">
                                    <div class="grid-sizer"></div>
                                    <?php
                                        if(!empty($recent_videos)){
                                            foreach($recent_videos as $video){
                                    ?>
                                        <div class="tg-portfolioitem tg-widthhalf">
                                            <figure>
                                                <a href="<?= site_url() ?>videos/view/<?= $video['rand_id']; ?>">
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
                                                    
                                                    <div class="tg-hover tg-hovervthree tg-portfoliohover">
                                                        <div class="tg-hoverholder">
                                                            <h2 class="text-center"><span><?= $video['video_title']; ?></span></h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </figure>
                                        </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                    </main>
        </main>
        
        <?php
            $this->load->view('block.foot.php');
        ?>
