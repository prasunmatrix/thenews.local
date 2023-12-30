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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings"><i class="fa fa-cogs"></i> &nbsp;<?= lang('settings'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/privacy_policy"><i class="fa fa-tags"></i> &nbsp;<?= lang('privacy_policy'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_privacy_and_policy'); ?></li>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="privacy_and_policy_form">
                                            <div class="col-md-9 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-body  no-padding">
                                                        <div class="col-md-12 no-padding">
                                                            <div id="editor" style="margin-bottom: 0px;"><div id='edit' style="margin-top: 0px;margin-bottom: 0px;"><?php if(isset($privacy_policy[0]['privacy_and_policy'])){ echo $privacy_policy[0]['privacy_and_policy']; } ?></div></div>
                                                            <textarea class="form-control" style="display: none;" id="terms" name="terms"><?php if(isset($privacy_policy[0]['privacy_and_policy'])){ echo $privacy_policy[0]['privacy_and_policy']; } ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-google-plus"></i> &nbsp;<?= lang('search_engine_optimization'); ?></div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-header"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeHolder="<?= lang('seo_title'); ?>" value="<?php  if(isset($privacy_policy[0]['seo_title'])){ echo $privacy_policy[0]['seo_title']; }?>">
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
                                                                            if(isset($privacy_policy[0]['seo_keywords'])){                                                                             
                                                                                $keywords = json_decode($privacy_policy[0]['seo_keywords']);
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
                                                                    <textarea class="form-control" rows="5" name="seo_desc" placeholder="<?= lang('seo_descriptions'); ?>"><?php  if(isset($privacy_policy[0]['seo_desc'])){ echo $privacy_policy[0]['seo_desc']; }?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                                <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                                <a href="<?= site_url() . DASHBOARD_DIR_NAME ?>settings/" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                            $(".privacy_and_policy_form").submit(function(e){
                                pills = $('#MyPillbox').pillbox('items');
                                if(pills.length>0){
                                    $("#seo_keywords").val(JSON.stringify(pills));
                                }
                                $("#terms").html($(".fr-view").html());
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.privacy_and_policy_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/settings/save_privacy_and_policy",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                
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
                            $(function () {
                                $("#seo_title").focus();
                                $('#edit').froalaEditor({
                                    placeholderText: "<?= lang('write_privacy_and_policy_here'); ?>",

                                    // Set the file upload URL.
                                    type: "post",
                                    imageUploadURL: "<?= site_url() ?>api/files/upload_image",
                                    imageUploadParams: {
                                        id: 'my_editor'
                                    },
                                    imageDefaultWidth: 0,
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
                                $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_privacy_and_policy_here'); ?>");
                                $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                    e.preventDefault();
                                });
                            });
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
