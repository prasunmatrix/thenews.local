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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>news_types"><i class="fa fa-sitemap"></i> &nbsp;<?= lang('news_types'); ?></a></li>
                                    <?php
                                        if($this->uri->segment(4)=='add'){
                                    ?>
                                        <li class="active"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_news_type'); ?></li>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_new_news_type'); ?></li>
                                    <?php        
                                        }
                                    ?>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="news_type_form">
                                            <div class="col-md-8 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php
                                                            if($this->uri->segment(4)=='add'){
                                                        ?>
                                                            <i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_news_type'); ?>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_new_news_type'); ?>
                                                        <?php        
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="hidden" name="news_type_id" class="form-control" value="<?php  if(isset($news_type_details[0]['news_type_id'])){ echo $news_type_details[0]['news_type_id']; }?>">                                                            
                                                                <input type="text" name="news_type_title" class="form-control news_type_title" placeholder="<?= lang('news_type_title'); ?>" value="<?php  if(isset($news_type_details[0]['news_type_title'])){ echo $news_type_details[0]['news_type_title']; }?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </div>
                                                                <input type="text" name="news_type_url" class="form-control news_type_url" placeholder="<?= lang('news_type_url'); ?>" value="<?php  if(isset($news_type_details[0]['rand_id'])){ echo $news_type_details[0]['rand_id']; }?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <p><label for="news_type_image"><?= lang('upload_news_type_thumbnail'); ?></label></p>
                                                            <input type="file" id="news_type_image" name="news_type_image" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-tags"></i>
                                                                </div>
                                                                <?php
                                                                    $check_array = array();
                                                                    if(isset($news_type_topics)){
                                                                        foreach($news_type_topics as $topic){
                                                                            $check_array[] = $topic['topic_id'];
                                                                        }
                                                                    }
                                                                ?>
                                                                <select class="form-control topics" name="topics[]" multiple> 
                                                                <?php
                                                                    foreach ($topics as $topic) {
                                                                        if(in_array($topic['topic_id'], $check_array)){
                                                                        ?>
                                                                            <option value="<?= $topic['topic_id']; ?>" selected><?= $topic['topic_name']; ?></option> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                        ?>
                                                                            <option value="<?= $topic['topic_id']; ?>"><?= $topic['topic_name']; ?></option> 
                                                                        <?php    
                                                                        }
                                                                    }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?></div>
                                                        <div class="panel-body">
                                                            <?= lang('no_instructions_found'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">                                                
                                                <div id="editor">
                                                    <div id='edit' style="margin-top: 10px;margin-bottom: 10px;">
                                                        <?php if(isset($news_type_details[0]['news_type_desc'])){ echo $news_type_details[0]['news_type_desc']; } ?>
                                                    </div>
                                                </div>
                                                <textarea class="form-control" style="display: none;" id="news_type_desc" name="news_type_desc"><?php if(isset($news_type_details[0]['news_type_desc'])){ echo $news_type_details[0]['news_type_desc']; } ?></textarea>                                                
                                            </div>
                                            <div class="col-md-8 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><i class="fa fa-google-plus"></i> &nbsp;<?= lang('search_engine_optimization'); ?></div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="text" class="form-control" name="seo_title" placeHolder="<?= lang('seo_title'); ?>" value="<?php  if(isset($news_type_details[0]['seo_title'])){ echo $news_type_details[0]['seo_title']; }?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-keyboard-o"></i>
                                                                </div>
                                                                <div id="MyPillbox" class="pillbox clearfix">
                                                                    <?php
                                                                        $keywords = array();
                                                                        if(isset($news_type_details[0]['seo_keywords'])){                                                                             
                                                                            $keywords = json_decode($news_type_details[0]['seo_keywords']);
                                                                        }
                                                                    ?>
                                                                    <ul>
                                                                        <?php
                                                                            if(!empty($keywords)){
                                                                                foreach ($keywords as $key){
                                                                        ?>
                                                                                <li class="label bg-dark"><?= $key->text; ?></li>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        
                                                                        <input type="text"  placeHolder="<?= lang('add_new_keyword'); ?>">
                                                                        <input type="hidden" id="seo_keywords" name="seo_keyword">
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <textarea class="form-control" rows="5" name="seo_desc" placeholder="<?= lang('seo_descriptions'); ?>"><?php  if(isset($news_type_details[0]['seo_desc'])){ echo $news_type_details[0]['seo_desc']; }?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                            <a href="<?= site_url() . DASHBOARD_DIR_NAME ?>news_types" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                                get_news_types_datatable();
                                
                            });
                            $(".news_type_form").submit(function(e){
                                    pills = $('#MyPillbox').pillbox('items');
                                    if(pills.length>0){
                                        $("#seo_keywords").val(JSON.stringify(pills));
                                    }                                        
                                    $("#news_type_desc").html($(".fr-view").html());                        
                                    e.preventDefault();                                
                                    $(".submit_btn").prop('disabled',true);
                                    $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                    form = $('.news_type_form')[0];
                                    data = new FormData(form);
                                    $.ajax({
                                        data: data,
                                        type: "post",
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        url: "<?= site_url() ?>api/news_types/save_news_type_details",
                                        success: function (data) {
                                            if (data.status) {
                                                alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                    window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>news_types/view/"+data.next;
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
                            function get_news_types_datatable(){
                                table = $('.news_types_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,

                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/news_types/list_news_types_datatable",
                                       "type": "POST"
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [ 4 ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".news_types_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                            <?php
                                if($this->permissions_model->check('news_types','delete')){
                            ?>
                                function delete_news_type(news_type_id){
                                    if(news_type_id){
                                        alertify.confirm("<?= lang('are_you_sure'); ?>", "<?= lang('do_you_want_to_delete_news_type'); ?>", function(){
                                            $.ajax({
                                                data: {news_type_id:news_type_id},
                                                type: "post",
                                                dataType: 'json',
                                                url: "<?= site_url() ?>api/news_types/delete_news_type_details",
                                                success: function (data) {
                                                    if (data.status) {
                                                        alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                            get_news_types_datatable();
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
                        $(".news_type_title").bind("keyup change", function(e) {
                            name = $(".news_type_title").val();
                            name = name.toLowerCase();
                            slug = name.replace(/[^A-Z0-9]+/ig, "-");
                            $(".news_type_url").val(slug);
                        });

                        $(".news_type_url").bind("keyup change", function(e) {
                            $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                        });
                        $(function () {
                            $(".news_type_title").focus();
                            $('#edit').froalaEditor({
                                placeholderText: "<?= lang('write_news_type_descriptions_here'); ?>",

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
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_news_type_descriptions_here'); ?>");
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                e.preventDefault();
                            });
                        });
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
