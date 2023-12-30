<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view('_head.php');
?>

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
        <meta property="og:url"           content="<?= site_url(); ?>news/view/<?= $news_details[0]['rand_id']; ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_title'])); ?>" />
        <meta property="og:description"   content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_desc'])); ?>" />
        <meta property="og:image"         content="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['thumbnail']; ?>" />
        <meta property="og:site_name"     content="Pratibadi Kalam">     
        <meta property="article:published_time" content="<?= date('Y-m-d\TH:m:sP',$news_details[0]['date_created']); ?>" />
        <meta property="article:modified_time" content="<?= date('Y-m-d\TH:m:sP',$news_details[0]['date_modified']); ?>" />
        <meta property="article:section" content="<?= str_replace('"', '', str_replace("'", "", $news_details[0]['seo_title'])); ?>" />
        <meta property="article:tag" content="<?= $keywords ?>" />
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
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="tg-detailbox">
                                            <h2><?= $news_details[0]['news_title']; ?></h2>
                                            <ul class="tg-postmetadata">
                                                    <li>
                                                        <span><a href="<?= site_url() ?>category/view/<?= $news_details[0]['news_type_rand_id']; ?>"><?= $news_details[0]['news_type_title']; ?></a></span>
                                                        &emsp;/&emsp;
                                                        <time datetime="<?= date('Y-m-d',$news_details[0]['date_created']); ?>"><?= date($configs['date_format'],$news_details[0]['date_created']); ?></time>
                                                    </li>
                                            </ul>
                                            <figure class="tg-blogdetailimg">
                                                <?php
                                                    if($news_details[0]['l_thumbnail']!=""){
                                                ?>
                                                    <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['l_thumbnail']; ?>" title="<?= $news_details[0]['seo_title']; ?>" alt="<?= $news_details[0]['rand_id']; ?>">
                                                <?php
                                                    }
                                                    else{
                                                ?>
                                                    <img src="/public_html/images/thumbnail.png" title="<?= $news_details[0]['seo_title']; ?>" alt="<?= $news_details[0]['rand_id']; ?>">
                                                <?php        
                                                    }
                                                ?>
                                            </figure>
                                            <div class="tg-sharepost" style="padding-top: 0px; padding-bottom: 10px; border-bottom: 0px;">
                                                <ul class="tg-socialicons">
                                                    <!--<li class="tg-likepost">
                                                        <a href="whatsapp://send?text=Hello friend!"  data-action="share/whatsapp/share" xonclick="shareToFb();"><i class="icon-heart5"></i><span>Love</span></a>
                                                    </li>-->
                                                    <li class="tg-facebook">
                                                        <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= site_url() ?>news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-facebook-1"></i></a>
                                                    </li>
                                                    <li class="tg-twitter">
                                                        <a onclick="window.open('https://twitter.com/intent/tweet?text=<?= site_url() ?>news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-twitter-1"></i></a>
                                                    </li>
                                                    <li class="tg-whatsapp">
                                                        <a data-action="share/whatsapp/share" onclick="window.open('https://api.whatsapp.com/send?text=<?= site_url() ?>news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-whatsapp" style="padding-left:2px;"></i></a>
                                                    </li>
                                                    <li class="tg-linkedin">
                                                        <a onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url() ?>news/view/<?= $news_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-linkedin22" style="padding-left:3px;"></i></a>
                                                    </li>
                                                    <?php
                                                        if(isset($bookmark)){
                                                         ?>
                                                         <li class="tg-linkedin">
                                                            <a onclick="removeBookmarkPost()" href="#"><i class="icon-book-bookmark2" style="padding-left:3px;"></i></a>
                                                        </li>
                                                         <?php
                                                        }
                                                        else{
                                                    ?>
                                                    <li class="tg-linkedin">
                                                        <a onclick="saveBookmarkPost()" href="#"><i class="icon-book-bookmark2" style="padding-left:3px;"></i></a>
                                                    </li>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                </ul>
                                            </div>
                                            <div class="tg-description">
                                                <?php
                                                    if($this->session->userdata('normal_user')){
                                                        if(@$subscription_end_date!="0000-00-00" && time()< strtotime(@$subscription_end_date)){
                                                            echo "<div class='col-md-12'>";
                                                                echo $news_details[0]['news_desc'];
                                                            echo "</div>";
                                                        }
                                                        else{
                                                            echo mb_strimwidth($news_details[0]['news_desc'], 0, 250, '...');
                                                            echo "<br>";
                                                            echo "<br>";
                                                            echo "<div class='col-md-12'>";
                                                            echo "<center><a href='#' onclick='openLoginBanner(2)' class='btn btn-default'>" . lang('subscribe_to_view_full_news') . "</a></center>";
                                                            echo "<br>";
                                                            echo "<br>";
                                                            echo "</div>";
                                                        }
                                                    }
                                                    else{
                                                        echo mb_strimwidth($news_details[0]['news_desc'], 0, 250, '...');
                                                        echo "<br>";
                                                        echo "<br>";
                                                        echo "<div class='col-md-12'>";
                                                        echo "<center><a href='#' onclick='openLoginBanner(1)' class='btn btn-default'>" . lang('login_to_view_full_news') . "</a></center>";
                                                        echo "<br>";
                                                        echo "<br>";
                                                        echo "</div>";
                                                        
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <section class="" style="padding: 0px; padding-top: 20px; padding-bottom: 50px; border-top: 1px #e7e7e7 solid">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="tg-posts">
                                                    <h2 class="text-center" style="font-size: 25px;"><?= lang('related_to_this_news'); ?></h2>
                                                    <div class="col-lg-12 no-padding related_articles">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
<!--                            <div class="tg-nextprevpost">
                                <div class="tg-prevpost">
                                    <?php
                                        if(!empty($previous_post)){
                                    ?>
                                    <figure>
                                        <a href="<?= site_url() ?>news/view/<?= $previous_post[0]['rand_id']; ?>">
                                            <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $previous_post[0]['s_thumbnail']; ?>" alt="image description" style="height:400px;">
                                            <div class="tg-nextprevcontent padding-50">
                                                <span><?= $previous_post[0]['news_type_title']; ?></span>
                                                <h3><?= $previous_post[0]['news_title']; ?></h3>
                                            </div>
                                        </a>
                                    </figure>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="tg-nextpost">
                                    <?php
                                        if(!empty($next_post)){
                                    ?>
                                    <figure>
                                        <a href="<?= site_url() ?>news/view/<?= $next_post[0]['rand_id']; ?>">
                                            <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $next_post[0]['s_thumbnail']; ?>" alt="image description" style="height:400px;">
                                            <div class="tg-nextprevcontent padding-50">
                                                <span><?= $next_post[0]['news_type_title']; ?></span>
                                                <h3><?= $next_post[0]['news_title']; ?></h3>
                                            </div>
                                        </a>
                                    </figure>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!--************************************
                                                Blog Detail End
                *************************************-->
            </main>
            <script>
                $(document).ready(function(e){
                    get_related_article(<?= $news_details[0]['news_type_id']; ?>,<?= $news_details[0]['news_id']; ?>,'<?= $this->uri->segment(1); ?>');
                });
                
                function saveBookmarkPost(){
                    $.ajax({
                        url:"<?= site_url() ?>api/news/save_bookmark",
                        data:{"entity":"news","entity_id":"<?= $news_details[0]['news_id'] ?>"},
                        dataType:"json",
                        type:"post",
                        success:function(res){
                            if(res.status){
                                 alertify.alert("<?= lang('notifications'); ?>", res.message , function(){
                                    location.reload();
                                }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                            }
                            else{
                                if(res.next){
                                    window.location.href = res.next;
                                }
                                console.log(res.message);
                            }
                        },
                        error:function(err){
                            console.log(err);
                        },
                    });
                }
                function removeBookmarkPost(){
                    $.ajax({
                        url:"<?= site_url() ?>api/news/delete_bookmark",
                        data:{"entity":"news","entity_id":"<?= $news_details[0]['news_id'] ?>"},
                        dataType:"json",
                        type:"post",
                        success:function(res){
                            if(res.status){
                                 alertify.alert("<?= lang('notifications'); ?>", res.message , function(){
                                    location.reload();
                                }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                            }
                            else{
                                if(res.next){
                                    window.location.href = res.next;
                                }
                                console.log(res.message);
                            }
                        },
                        error:function(err){
                            console.log(err);
                        },
                    });
                }
            </script>

    <?php
    $this->load->view('block.foot.php');
    ?>
