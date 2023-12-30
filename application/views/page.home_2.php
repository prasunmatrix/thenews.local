<?php
    $this->load->view('_head.php');
?>
        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title>Latest bollywood news|Gossips|Masala news|Hollywood|Movies|Trailers|Web series|Artists|Photos|Box office|Awards|Movie reviews|Songs|Short movies|Television Serials</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index, follow">
        <meta name="description" content="theFilmyGyan.com provides Latest bollywood news, Gossips, Masala news, Hollywood, Movies, Trailers, Web series, Artists, Photos, Box office, Awards, Movie reviews, Songs, Short movies and Television Serials details on a short and beautiful way.">
        <meta name="keywords" content="Latest bollywood news|Gossips|Masala news|Hot Bollywood masala|Hollywood|Movies|Trailers|Web series|Artists|Photos|Box office|Awards|Movie reviews|Songs|Short movies|Television Serials">
        <meta name="author" content="thefilmygyan.com">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="Latest bollywood news|Gossips|Masala news|Hollywood|Movies|Trailers|Web series|Artists|Photos|Box office|Awards|Movie reviews|Songs|Short movies|Television Serials">
        <meta name="twitter:description"  content="theFilmyGyan.com provides Latest bollywood news, Gossips, Masala news, Hollywood, Movies, Trailers, Web series, Artists, Photos, Box office, Awards, Movie reviews, Songs, Short movies and Television Serials details on a short and beautiful way.">
        <meta name="twitter:image"        content="/public_html/images/site-logo.png">
        <meta name="twitter:card"         content="thefilmygyan.com">        
        <meta property="og:url"           content="<?= site_url(); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="Latest bollywood news|Gossips|Masala news|Hollywood|Movies|Trailers|Web series|Artists|Photos|Box office|Awards|Movie reviews|Songs|Short movies|Television Serials" />
        <meta property="og:description"   content="theFilmyGyan.com provides Latest bollywood news, Gossips, Masala news, Hollywood, Movies, Trailers, Web series, Artists, Photos, Box office, Awards, Movie reviews, Songs, Short movies and Television Serials details on a short and beautiful way." />
        <meta property="og:image"         content="/public_html/images/site-logo.png" />
        <meta property="og:site_name"     content="thefilmygyan.com">     
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
        <main id="tg-main" style="margin-top: 120px;" class="tg-main tg-haslayout">
            <div class="container-fluid">
                <div class="row">
                    <div class="tg-blogpost tg-blogpostvtwo tg-bglight">
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
                                            <p><?= mb_strimwidth($post['news_desc'], 0, 97, '...'); ?></p>
                                        </div>
                                        <ul class="tg-postmetadata">
                                            <li>
                                                <figure>
                                                    <a href="<?= site_url() ?>author/view/<?= $post['user_rand_id']; ?>">
                                                        <?php
                                                            $author_img_src = "";
                                                            if($post['user_avatar']!=""){
                                                                $author_img_src = S3_URL.S3_BUCKET_NAME . "/images/" . $post['user_avatar'];
                                                            }
                                                            else{
                                                                $author_img_src = "/public_html/images/user.png";
                                                            }
                                                        ?>
                                                        <img src="<?= $author_img_src; ?>" class="author-avatar-small" alt="<?= $post['user_rand_id']; ?>">
                                                    </a>
                                                </figure>
                                                <span>By <a href="<?= site_url() ?>author/view/<?= $post['user_rand_id']; ?>"><?= $post['created_by']; ?></a></span>
                                            </li>
                                            <li><time datetime="<?= date('Y-m-d',$post['date_created']); ?>"><?= date($configs['date_format'],$post['date_created']); ?></time></li>
                                        </ul>
                                    </div>
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
        </main>
        
        <?php
            $this->load->view('block.foot.php');
        ?>