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
        <meta name="description" content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_desc'])); ?>">
        <?php
            $keywords = "";
            $k = json_decode($news_details[0]['seo_keywords']);
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
        <meta name="twitter:title"        content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_title']));; ?>">
        <meta name="twitter:description"  content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_desc'])); ?>">
        <meta name="twitter:image"        content="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['thumbnail']; ?>">
        <meta name="twitter:card"         content=".com">        
        <meta property="og:url"           content="<?= site_url(); ?>category/view/<?= $news_details[0]['rand_id']; ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_title'])); ?>" />
        <meta property="og:description"   content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_desc'])); ?>" />
        <meta property="og:image"         content="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['thumbnail']; ?>" />
        <meta property="og:site_name"     content=".com">     
        <meta property="article:published_time" content="<?= date('Y-m-d\TH:m:sP',$news_details[0]['date_created']); ?>" />
        <meta property="article:modified_time" content="<?= date('Y-m-d\TH:m:sP',$news_details[0]['date_modified']); ?>" />
        <meta property="article:section" content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_title'])); ?>" />
        <meta property="article:tag" content="<?= $keywords ?>" />
    </head>
    <body data-gr-c-s-loaded="true" class="js-focus-visible">

            <?php
                $this->load->view('block.head.php');
            ?>

            <div id="tg-innerbanner" class="tg-innerbanner">
                <?php
                    if($news_details[0]['l_thumbnail']!=""){
                ?>
                    <figure data-vide-bg="poster: <?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['l_thumbnail']; ?>" data-vide-options="position: 0% 50%">
                <?php
                    }
                ?>
                
                    <!--<figcaption>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h1><?= $news_details[0]['news_title']; ?></h1>
                                    <h2><?= $news_details[0]['news_desc']; ?></h2>
                                            <div class="col-md-12">
                                                <div class="col-md-3"> &emsp;</div>
                                                <div class="col-md-6">
                                                    <center>
                                                        <div class="tg-sharepost col-md-12" style="padding-top: 0px; padding-bottom: 40px; border-bottom: 0px;">
                                                            <ul class="tg-socialicons">
                                                                <!--<li class="tg-likepost">
                                                                    <a href="whatsapp://send?text=Hello friend!"  data-action="share/whatsapp/share" xonclick="shareToFb();"><i class="icon-heart5"></i><span>Love</span></a>
                                                                </li>
                                                                <li class="tg-facebook">
                                                                    <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= site_url() ?>exclusive_news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-facebook-1"></i></a>
                                                                </li>
                                                                <li class="tg-twitter">
                                                                    <a onclick="window.open('https://twitter.com/intent/tweet?text=<?= site_url() ?>exclusive_news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-twitter-1"></i></a>
                                                                </li>
                                                                <li class="tg-whatsapp">
                                                                    <a data-action="share/whatsapp/share" onclick="window.open('https://api.whatsapp.com/send?text=<?= site_url() ?>exclusive_news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-whatsapp" style="padding-left:2px;"></i></a>
                                                                </li>
                                                                <li class="tg-linkedin">
                                                                    <a onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url() ?>exclusive_news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-linkedin22" style="padding-left:3px;"></i></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </center>
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </figcaption>-->
                </figure>
            </div>
            <main id="tg-main" class="tg-main tg-haslayout">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='margin-top:100px;'>
                    <h2 class='text-center'><?= $news_details[0]['news_title']; ?></h2>
                    <?= $news_details[0]['news_desc']; ?>
                </div>
                <?php
                    if(!empty($news_posts)){
                        $count = 0;
                        foreach($news_posts as $post){
                            
                ?>
                            <div class="tg-ourprocess">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="tg-sectionhead tg-sectionheadvtwo">
                                                <div class="tg-sectiontitle">
                                                    <h2><?= $post['news_title']; ?></h2>
                                                </div>
                                                <ul class="tg-postmetadata" style="color: black;">
                                                    <!--<li><span>By <a href="javascript:void(0);">Haley</a></span></li>-->
                                                    <li><time datetime="2017-07-07"><?= date($this->configs['date_format'] . ' ' . $this->configs['time_format'], $post['date_created']); ?></time></li>
                                                </ul>
                                            </div>
                                            <?php
                                                if ($post['l_thumbnail'] != "") {
                                            ?>
                                                <figure class="tg-processimg col-md-12"><img src="<?= S3_URL . S3_BUCKET_NAME ?>/images/<?= $post['l_thumbnail']; ?>" alt="image description" style='margin-bottom:20px;'></figure>
                                                <div class="tg-processcontent  col-md-12">
                                            <?php
                                                } 
                                                else {
                                            ?>
                                                    <div class="tg-processcontent  col-md-12">
                                            <?php
                                                }
                                            ?>
                                                    <div class="tg-description">
                                                        <p><?= $post['news_desc']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                            
                        }
                    }
                ?>
            </main>
    <?php
    $this->load->view('block.foot.php');
    ?>