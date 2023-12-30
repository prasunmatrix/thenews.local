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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>epaper"><i class="fa fa-newspaper-o"></i> &nbsp;<?= lang('epaper'); ?></a></li>
                                    <li class="active">&nbsp;<?php if(isset($epaper_details[0]['epaper_title'])){ echo $epaper_details[0]['epaper_title']; } ?></li>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="epaper_type_form">
                                            <div class="col-md-8 no-padding">                                                
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><?php if(isset($epaper_details[0]['epaper_title'])){ echo $epaper_details[0]['epaper_title']; } ?></div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <?php
                                                                if(!empty($epapers)){
                                                                    foreach($epapers as $page){
                                                                        $filename = $page['thumbnail'];
                                                                        $filename_arr = explode(".", $filename);
                                                                        if(end($filename_arr)=="pdf"){
                                                            ?>
                                                                    <div class="col-md-12" style="margin-bottom: 25px;">
                                                                        <p class="text-center font-bold"><?= lang('page'); ?> <?= $page['page_num']; ?></p>
                                                                        <a href="<?= S3_URL.S3_BUCKET_NAME.'/pdfs/'. $page['thumbnail']; ?>">
                                                                            <iframe src="<?= S3_URL.S3_BUCKET_NAME.'/pdfs/'. $page['thumbnail']; ?>" class="img-responsive" style="min-height: 750px;width:100%;"></iframe>
                                                                        </a>
                                                                    </div>
                                                            <?php
                                                                        }
                                                                        else{
                                                            ?>
                                                                    <div class="col-md-4" style="margin-bottom: 25px;">
                                                                        <p class="text-center font-bold"><?= lang('page'); ?> <?= $page['page_num']; ?></p>
                                                                        <a href="<?= S3_URL.S3_BUCKET_NAME.'/images/'. $page['thumbnail']; ?>" data-lightbox="roadtrip">
                                                                            <img src="<?= S3_URL.S3_BUCKET_NAME.'/images/'. $page['s_thumbnail']; ?>" class="img-responsive" style="height: 450px;"/>
                                                                        </a>
                                                                    </div>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    echo lang('no_epaper_found');
                                                                }
                                                            ?>
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
                                                                <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>epaper/edit/<?= $epaper_details[0]['rand_id']; ?>"><i class="fa fa-pencil"></i></a></span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col-xs-12" style="padding: 0px;">
                                                                <div class="col-xs-5">
                                                                    <p class="pull-right"><?= lang('author'); ?></p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <?php
                                                                        if($epaper_details[0]['user_created']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$epaper_details[0]['user_created']));
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
                                                            <div class="col-xs-12" style="padding: 0px;">
                                                                <div class="col-xs-5">
                                                                    <p class="pull-right"><?= lang('published_date'); ?></p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <strong><?= $epaper_details[0]['date_created'] ? date('M d,Y h:i A',$epaper_details[0]['date_created']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="padding: 0px;">
                                                                <div class="col-xs-5">
                                                                    <p class="pull-right"><?= lang('last_updated'); ?></p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <strong><?= $epaper_details[0]['date_modified'] ? date('M d,Y h:i A',$epaper_details[0]['date_modified']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="padding: 0px;">
                                                                <div class="col-xs-5">
                                                                    <p class="pull-right"><?= lang('updated_by'); ?></p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <?php
                                                                        if($epaper_details[0]['user_modified']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$epaper_details[0]['user_modified']));
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
                                                            <div class="col-xs-12" style="padding: 0px;">
                                                                <div class="col-xs-5">
                                                                    <p class="pull-right"><?= lang('topics'); ?></p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <?php
                                                                        $check_array = array();
                                                                        if(isset($epaper_topics)){
                                                                            foreach($epaper_topics as $topic){
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
                                                                <p><?php  if(isset($epaper_details[0]['seo_title'])){ if(trim($epaper_details[0]['seo_title'])!=""){ echo $epaper_details[0]['seo_title']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <p class="font-bold"><?= lang('seo_keywords'); ?></p>
                                                                <?php
                                                                    $keywords = array();
                                                                    if(isset($epaper_details[0]['seo_keywords'])){                                                                             
                                                                        $keywords = json_decode($epaper_details[0]['seo_keywords']);
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
                                                                <p><?php  if(isset($epaper_details[0]['seo_desc'])){ if(trim($epaper_details[0]['seo_desc']!="")){ echo $epaper_details[0]['seo_desc']; } else{ echo lang('not_available'); } } else{ echo lang('not_available'); } ?></p>
                                                            </div>
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
                                get_epaper_types_datatable();
                                
                            });
                            $(".epaper_type_form").submit(function(e){
                                    pills = $('#MyPillbox').pillbox('items');
                                    if(pills.length>0){
                                        $("#seo_keywords").val(JSON.stringify(pills));
                                    }                                        
                                    $("#epaper_desc").html($(".fr-view").html());                        
                                    e.preventDefault();                                
                                    $(".submit_btn").prop('disabled',true);
                                    $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                    form = $('.epaper_type_form')[0];
                                    data = new FormData(form);
                                    $.ajax({
                                        data: data,
                                        type: "post",
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        url: "<?= site_url() ?>api/epaper_types/save_epaper_type_details",
                                        success: function (data) {
                                            if (data.status) {
                                                alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                    window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>epaper_types/view/"+data.next;
                                                }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();                                        
                                            } else {
                                                alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                                }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                            }
                                            $(".submit_btn").html("<?= lang('save'); ?>");
                                            $(".submit_btn").prop("disabled",false);
                                        },
                                        error:function(err){
                                            alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){
                                                console.log();
                                                $(".submit_btn").html("<?= lang('save'); ?>");
                                                $(".submit_btn").prop("disabled",false);
                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                        }
                                    });
                                });
                            function get_epaper_types_datatable(){
                                table = $('.epaper_types_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,

                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/epaper_types/list_epaper_types_datatable",
                                       "type": "POST"
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [ 4 ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".epaper_types_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                            <?php
                                if($this->permissions_model->check('epaper_types','delete')){
                            ?>
                                function delete_epaper_type(epaper_type_id){
                                    if(blog_id){
                                        alertify.confirm("<?= lang('are_you_sure'); ?>", "<?= lang('do_you_want_to_delete_epaper_type'); ?>", function(){
                                            $.ajax({
                                                data: {epaper_type_id:epaper_type_id},
                                                type: "post",
                                                dataType: 'json',
                                                url: "<?= site_url() ?>api/epaper_types/delete_epaper_type_details",
                                                success: function (data) {
                                                    if (data.status) {
                                                        alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                            get_epaper_types_datatable();
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
                                            console.log('no');
                                        }).set({transition:'zoom'}).show().set('labels', {ok:"<?= lang('yes'); ?>", cancel:"<?= lang('no'); ?>"});
                                    }                            
                                }            
                            <?php
                                }
                            ?>
                        $(".epaper_title").bind("keyup change", function(e) {
                            name = $(".epaper_title").val();
                            name = name.toLowerCase();
                            slug = name.replace(/[^A-Z0-9]+/ig, "-");
                            $(".epaper_type_url").val(slug);
                        });

                        $(".epaper_type_url").bind("keyup change", function(e) {
                            $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                        });
                        $(function () {
                            $('#edit').froalaEditor({
                                placeholderText: "<?= lang('write_epaper_descriptions_here'); ?>",

                                // Set the file upload URL.
                                type: "post",
                                imageUploadURL: "<?= site_url() ?>api/files/upload_image",
                                imageUploadParams: {
                                    id: 'my_editor'
                                },
                                // Set the file upload URL.
                                type: "post",
                                fileUploadURL:  "<?= site_url() ?>api/files/upload_file",
                                fileUploadParams: {
                                    id: 'my_editor'
                                },
                                // Set the video upload URL.
                                type: "post",
                                videoUploadURL: "<?= site_url() ?>api/files/upload_video",
                                videoUploadParams: {
                                    id: 'my_editor'
                                },
                            });
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_epaper_descriptions_here'); ?>");
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                e.preventDefault();
                            });
                        });
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
