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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>live_news"><i class="fa fa-newspaper-o"></i> &nbsp;<?= lang('live_news'); ?></a></li>
                                    <li class="active">&nbsp;<?php if(isset($news_details[0]['news_title'])){ echo $news_details[0]['news_title']; } ?></li>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="news_type_form">
                                            <div class="col-md-8 no-padding">                                                
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php if(isset($news_details[0]['news_title'])){ echo $news_details[0]['news_title']; } ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                            <p class="font-bold"><?= lang('news_title'); ?></p>
                                                            <p><?php  if(isset($news_details[0]['news_title'])){ echo $news_details[0]['news_title']; } else{ echo lang('not_available'); } ?></p>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                            <p class="font-bold"><?= lang('news_description'); ?></p>
                                                            
                                                            <p><?php  if(isset($news_details[0]['news_desc'])){ if(trim($news_details[0]['news_desc']!="<p><br></p>")){ echo $news_details[0]['news_desc']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                                <?php if($news_details[0]['parent_news_id']=="0"){ ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?= lang('live_news_posts'); ?>
                                                         <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>live_news/add/<?= $news_details[0]['news_id']; ?>"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_posts'); ?></a></span> 
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped m-b-none news_datatable">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="max-width: 120px"><?= lang('sr_no'); ?></th>
                                                                        <th><?= lang('news'); ?></th>
                                                                        <th><?= lang('author'); ?></th>
                                                                        <th><?= lang('published_date'); ?></th>
                                                                        <th style="max-width: 120px"><?= lang('actions'); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                            <?php
                                                                if($this->permissions_model->check('events','edit')){                
                                                            ?>
                                                                <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>live_news/edit/<?= $news_details[0]['rand_id']; ?>"><i class="fa fa-pencil"></i></a></span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('parent_news'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        $news_type = lang('not_available');
                                                                        
                                                                        if(!empty($news)){
                                                                            foreach($news as $type){
                                                                                if($news_details[0]['parent_news_id']==$type['news_id']){                                                                                    
                                                                                    $news_type = "<strong><a href='". site_url().DASHBOARD_DIR_NAME."live_news/view/".$type['rand_id']."'>".$type['news_title']."</a></strong>";
                                                                                }
                                                                            }
                                                                        }
                                                                        echo $news_type;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('author'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        if($news_details[0]['user_created']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$news_details[0]['user_created']));
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
                                                                    <strong><?= $news_details[0]['date_created'] ? date('M d,Y h:i A',$news_details[0]['date_created']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('last_updated'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong><?= $news_details[0]['date_modified'] ? date('M d,Y h:i A',$news_details[0]['date_modified']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('updated_by'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        if($news_details[0]['user_modified']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$news_details[0]['user_modified']));
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
                                                                        if(isset($news_topics)){
                                                                            foreach($news_topics as $topic){
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
                                                                <p><?php  if(isset($news_details[0]['seo_title'])){ if(trim($news_details[0]['seo_title'])!=""){ echo $news_details[0]['seo_title']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <p class="font-bold"><?= lang('seo_keywords'); ?></p>
                                                                <?php
                                                                    $keywords = array();
                                                                    if(isset($news_details[0]['seo_keywords'])){                                                                             
                                                                        $keywords = json_decode($news_details[0]['seo_keywords']);
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
                                                                <p><?php  if(isset($news_details[0]['seo_desc'])){ if(trim($news_details[0]['seo_desc']!="")){ echo $news_details[0]['seo_desc']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-image"></i> &nbsp;<?= lang('news_thumbnail'); ?></div>
                                                        <div class="panel-body">
                                                            <?php
                                                                if(isset($news_details[0]['thumbnail'])){
                                                                    if($news_details[0]['thumbnail']!=""){
                                                            ?>
                                                                <center><img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $news_details[0]['s_thumbnail']; ?>" class="img-responsive img-rounded"/></center>
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
                        <script>                            
                            $(document).ready(function(e){
                                get_news_datatable();
                            });
                            function get_news_datatable(){
                                table = $('.news_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,

                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/news/list_live_sub_news_datatable",
                                       "data": {live_news_id:<?= $news_details[0]['news_id']; ?>},
                                       "type": "POST"
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [ 0,4 ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".news_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                            <?php
                                if($this->permissions_model->check('news','delete')){
                            ?>
                                function delete_news(id){
                                    if(id){
                                        alertify.confirm("<?= lang('are_you_sure'); ?>", "<?= lang('do_you_want_to_delete_live_news'); ?>", function(){
                                            $.ajax({
                                                data: {id:id},
                                                type: "post",
                                                dataType: 'json',
                                                url: "<?= site_url() ?>api/news/delete_live_news_details",
                                                success: function (data) {
                                                    if (data.status) {
                                                        alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                            get_news_datatable();
                                                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();                                        
                                                    } else {
                                                        alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                                    }
                                                },
                                                error:function(err){
                                                    alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){

                                                    }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                                }
                                            });
                                        },
                                        function(){
                                        }).set({transition:'zoom'}).show().set('labels', {ok:"<?= lang('yes'); ?>", cancel:"<?= lang('no'); ?>"});
                                    }                            
                                }            
                            <?php
                                }
                            ?>
                                function changeHomeSliderStatus(id){
                                    if ($('#news_'+id).prop('checked')){
                                        val = "1";
                                    }
                                    else{
                                        val = "0";
                                    }
                                    $.ajax({
                                        data: {val:val, id:id},
                                        type: "post",
                                        dataType: 'json',
                                        url: "<?= site_url() ?>api/news/change_news_home_slider_status",
                                        success: function (data) {
                                            if(data.status){
                                                alertify.notify(data.message, 'success', 5, function(){  console.log('dismissed'); });
                                                get_news_datatable();
                                            }
                                            else{
                                                alertify.notify(data.message, 'warning', 5, function(){  console.log('dismissed'); });
                                            }
                                        }
                                    });
                                }
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
