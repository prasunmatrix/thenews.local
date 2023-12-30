<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php  $this->load->view('dashboard/_head.php'); ?>

    </head>
    <body class="">
    <?php $this->load->view('dashboard/block.head.php'); ?>
        
<?php } ?>
                        <title><?php echo $page_title; ?> - <?php echo lang('site_title'); ?></title>
                        <section class="vbox bg-gradient content-vbox">
                            <header class="header b-b b-t b-light bg-light lter">
                                <ul class="breadcrumb no-border no-radius">
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('dashboard'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>videos"><i class="fa fa-video-camera"></i> &nbsp;<?= lang('videos'); ?></a></li>
                                    <li class="active">&nbsp;<?php if(isset($video_details[0]['video_title'])){ echo $video_details[0]['video_title']; } ?></li>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="video_type_form">
                                            <div class="col-md-8 no-padding">                                                
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php if(isset($video_details[0]['video_title'])){ echo $video_details[0]['video_title']; } ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <?php 
                                                                $video_url = $video_details[0]['video_url'];
                                                                $video_url_segment = str_replace("https://www.youtube.com/watch?v=","",$video_url);
                                                            ?>
                                                            <iframe width="100%" height="500" src="https://www.youtube.com/embed/<?= $video_url_segment; ?>" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                            <p class="font-bold"><?= lang('video_title'); ?></p>
                                                            <h4><?php  if(isset($video_details[0]['video_title'])){ echo $video_details[0]['video_title']; } else{ echo lang('not_available'); } ?></h4>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                            <p class="font-bold"><?= lang('video_description'); ?></p>
                                                            
                                                            <p><?php  if(isset($video_details[0]['video_desc'])){ if(trim($video_details[0]['video_desc']!="<p><br></p>")){ echo $video_details[0]['video_desc']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                            <?php
                                                                if($this->permissions_model->check('events','edit')){                
                                                            ?>
                                                                <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>videos/edit/<?= $video_details[0]['rand_id']; ?>"><i class="fa fa-pencil"></i></a></span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('author'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        if($video_details[0]['user_created']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$video_details[0]['user_created']));
                                                                            $name = "";
                                                                            if(!empty($user_details)){
                                                                                $name = "<strong>".$user_details[0]['first_name'] . ' ' . $user_details[0]['last_name']."</strong>";
                                                                                echo $name;
                                                                            }
                                                                            else{
                                                                                echo "--";
                                                                            }
                                                                        }
                                                                        else{
                                                                            echo "--";
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('published_date'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong><?= $video_details[0]['date_created'] ? date('M d,Y h:i A',$video_details[0]['date_created']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('last_updated'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong><?= $video_details[0]['date_modified'] ? date('M d,Y h:i A',$video_details[0]['date_modified']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('updated_by'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        if($video_details[0]['user_modified']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$video_details[0]['user_modified']));
                                                                            $name = "";
                                                                            if(!empty($user_details)){
                                                                                $name = "<strong>".$user_details[0]['first_name'] . ' ' . $user_details[0]['last_name']."</strong>";
                                                                                echo $name;
                                                                            }
                                                                            else{
                                                                                echo "--";
                                                                            }
                                                                        }
                                                                        else{
                                                                            echo "--";
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('topics'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        $check_array = array();
                                                                        if(isset($videos_topics)){
                                                                            foreach($videos_topics as $topic){
                                                                                $check_array[] = $topic['topic_id'];
                                                                            }
                                                                        }
                                                                        if(empty($check_array)){
                                                                            echo lang('not_available');
                                                                        }
                                                                        else{
                                                                            foreach ($topics as $topic) {
                                                                                if(in_array($topic['topic_id'], $check_array)){
                                                                                    echo "<span class='btn btn-xs ".$topic['class_name']."' style='margin:2px;'>".$topic['topic_name']."</span>";
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-google-plus"></i> &nbsp;<?= lang('search_engine_optimization'); ?></div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <p class="font-bold"><?= lang('seo_title'); ?></p>
                                                                <p><?php  if(isset($video_details[0]['seo_title'])){ if(trim($video_details[0]['seo_title'])!=""){ echo $video_details[0]['seo_title']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <p class="font-bold"><?= lang('seo_keywords'); ?></p>
                                                                <?php
                                                                    $keywords = array();
                                                                    if(isset($video_details[0]['seo_keywords'])){                                                                             
                                                                        $keywords = json_decode($video_details[0]['seo_keywords']);
                                                                    }
                                                                    if(!empty($keywords)){
                                                                        foreach ($keywords as $key){
                                                                    ?>
                                                                        <span class="btn btn-xs btn-dark" style="margin-bottom: 2px;"><?= $key->text; ?></span>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    else{
                                                                        echo lang('not_available');
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <p class="font-bold"><?= lang('seo_desc'); ?></p>
                                                                <p><?php  if(isset($video_details[0]['seo_desc'])){ if(trim($video_details[0]['seo_desc']!="")){ echo $video_details[0]['seo_desc']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-image"></i> &nbsp;<?= lang('video_thumbnail'); ?></div>
                                                        <div class="panel-body">
                                                            <?php
                                                                if(isset($video_details[0]['thumbnail'])){
                                                                    if($video_details[0]['thumbnail']!=""){
                                                            ?>
                                                                <center><img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $video_details[0]['s_thumbnail']; ?>" class="img-responsive img-rounded"/></center>
                                                            <?php
                                                                    }
                                                                    else{
                                                            ?>
                                                                <center><img src="/public_html/images/thumbnail.png" class="img-responsive img-rounded" style="max-height: 250px"/></center>
                                                            <?php            
                                                                    }
                                                                }
                                                                else{
                                                            ?>
                                                                <center><img src="/public_html/images/thumbnail.png" class="img-responsive img-rounded" style="max-height: 250px"/></center>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                    
                                </div>
                            </section>
                        </section>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
