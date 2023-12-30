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
        <meta name="description" content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_desc'])); ?>">
        <?php
            $keywords = "";
            $k = json_decode($video_details[0]['seo_keywords']);
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
        <meta name="twitter:title"        content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_title']));; ?>">
        <meta name="twitter:description"  content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_desc'])); ?>">
        <meta name="twitter:image"        content="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $video_details[0]['thumbnail']; ?>">
        <meta name="twitter:card"         content=".com">        
        <meta property="og:url"           content="<?= site_url(); ?>category/view/<?= $video_details[0]['rand_id']; ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_title'])); ?>" />
        <meta property="og:description"   content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_desc'])); ?>" />
        <meta property="og:image"         content="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $video_details[0]['thumbnail']; ?>" />
        <meta property="og:site_name"     content=".com">     
        <meta property="article:published_time" content="<?= date('Y-m-d\TH:m:sP',$video_details[0]['date_created']); ?>" />
        <meta property="article:modified_time" content="<?= date('Y-m-d\TH:m:sP',$video_details[0]['date_modified']); ?>" />
        <meta property="article:section" content="<?= str_replace('"', '', str_replace("'", "", $video_details[0]['seo_title'])); ?>" />
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
                                            <figure class="tg-blogdetailimg">
                                                <?php 
                                                    $video_url = $video_details[0]['video_url'];
                                                    $video_url_segment = str_replace("https://www.youtube.com/watch?v=","",$video_url);
                                                ?>
                                                <iframe width="100%" height="800" src="https://www.youtube.com/embed/<?= $video_url_segment; ?>" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                                            </figure>
                                            <h2><?= $video_details[0]['video_title']; ?></h2>
                                            <ul class="tg-postmetadata">
                                                    <li>
                                                        
                                                        <time datetime="<?= date('Y-m-d',$video_details[0]['date_created']); ?>"><?= date($configs['date_format'],$video_details[0]['date_created']); ?></time>
                                                    </li>
                                                
                                            </ul>
                                            
                                            <div class="tg-sharepost" style="padding-top: 0px; padding-bottom: 40px; border-bottom: 0px;">
                                                <ul class="tg-socialicons">
                                                    <!--<li class="tg-likepost">
                                                        <a href="whatsapp://send?text=Hello friend!"  data-action="share/whatsapp/share" xonclick="shareToFb();"><i class="icon-heart5"></i><span>Love</span></a>
                                                    </li>-->
                                                    <li class="tg-facebook">
                                                        <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= site_url() ?>videos/view/<?= $video_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-facebook-1"></i></a>
                                                    </li>
                                                    <li class="tg-twitter">
                                                        <a onclick="window.open('https://twitter.com/intent/tweet?text=<?= site_url() ?>videos/view/<?= $video_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-twitter-1"></i></a>
                                                    </li>
                                                    <li class="tg-whatsapp">
                                                        <a data-action="share/whatsapp/share" onclick="window.open('https://api.whatsapp.com/send?text=<?= site_url() ?>videos/view/<?= $video_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-whatsapp" style="padding-left:2px;"></i></a>
                                                    </li>
                                                    <li class="tg-linkedin">
                                                        <a onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url() ?>videos/view/<?= $video_details[0]['rand_id']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" href="#"><i class="icon-linkedin22" style="padding-left:3px;"></i></a>
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
                                                <?= $video_details[0]['video_desc']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--************************************
                                                Blog Detail End
                *************************************-->
            </main>
            <script>
                function saveBookmarkPost(){
                    $.ajax({
                        url:"<?= site_url() ?>api/news/save_bookmark",
                        data:{"entity":"video","entity_id":"<?= $video_details[0]['video_id'] ?>"},
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
                        data:{"entity":"video","entity_id":"<?= $video_details[0]['video_id'] ?>"},
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