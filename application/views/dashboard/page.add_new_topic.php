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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/topics"><i class="fa fa-tags"></i> &nbsp;<?= lang('topics'); ?></a></li>
                                    <?php
                                        if($this->uri->segment(5)=='add'){
                                    ?>
                                        <li class="active"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_topic'); ?></li>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_topic_details'); ?></li>
                                    <?php        
                                        }
                                    ?>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="topic_form">
                                            <div class="col-md-8 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php
                                                            if($this->uri->segment(5)=='add'){
                                                        ?>
                                                            <i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_topic'); ?>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_topic_details'); ?>
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
                                                                <input type="hidden" name="topic_id" class="form-control" value="<?php  if(isset($topic_details[0]['topic_id'])){ echo $topic_details[0]['topic_id']; }?>">
                                                                <input type="text" name="topic_name" class="form-control topic_name" placeholder="<?= lang('topic_name'); ?>" value="<?php  if(isset($topic_details[0]['topic_name'])){ echo $topic_details[0]['topic_name']; }?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </div>
                                                                <input type="text" name="topic_url" class="form-control topic_url" placeholder="<?= lang('topic_url'); ?>" value="<?php  if(isset($topic_details[0]['rand_id'])){ echo $topic_details[0]['rand_id']; }?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-sitemap"></i>
                                                                </div>
                                                                <?php
                                                                    if(isset($topic_details[0]['class_name'])){
                                                                ?>
                                                                    <select class="form-control select2" name="class_name">
                                                                        <option value="btn btn-info" <?php if($topic_details[0]['class_name']=='btn btn-info'){ echo "selected"; } ?>>Info</option>
                                                                        <option value="btn btn-success" <?php if($topic_details[0]['class_name']=='btn btn-success'){ echo "selected"; } ?>>Success</option>
                                                                        <option value="btn btn-primary" <?php if($topic_details[0]['class_name']=='btn btn-primary'){ echo "selected"; } ?>>Primary</option>
                                                                        <option value="btn btn-danger" <?php if($topic_details[0]['class_name']=='btn btn-danger'){ echo "selected"; } ?>>Danger</option>
                                                                        <option value="btn btn-warning" <?php if($topic_details[0]['class_name']=='btn btn-warning'){ echo "selected"; } ?>>Warning</option>
                                                                        <option value="btn btn-default" <?php if($topic_details[0]['class_name']=='btn btn-default'){ echo "selected"; } ?>>Default</option>
                                                                        <option value="btn btn-dark" <?php if($topic_details[0]['class_name']=='btn btn-dark'){ echo "selected"; } ?>>Dark</option>
                                                                    </select>
                                                                <?php
                                                                    }
                                                                    else{
                                                                ?>
                                                                    <select class="form-control select2" name="class_name">
                                                                        <option value="btn btn-info">Info</option>
                                                                        <option value="btn btn-success">Success</option>
                                                                        <option value="btn btn-primary">Primary</option>
                                                                        <option value="btn btn-danger">Danger</option>
                                                                        <option value="btn btn-warning">Warning</option>
                                                                        <option value="btn btn-default">Default</option>
                                                                        <option value="btn btn-dark">Dark</option>
                                                                    </select>
                                                                <?php
                                                                    }
                                                                ?>

                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="text" class="form-control" name="seo_title" placeHolder="<?= lang('seo_title'); ?>" value="<?php  if(isset($topic_details[0]['seo_title'])){ echo $topic_details[0]['seo_title']; }?>">
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
                                                                        if(isset($topic_details[0]['seo_keywords'])){                                                                             
                                                                            $keywords = json_decode($topic_details[0]['seo_keywords']);
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
                                                                <textarea class="form-control" rows="5" name="seo_desc" placeholder="<?= lang('seo_descriptions'); ?>"><?php  if(isset($topic_details[0]['seo_desc'])){ echo $topic_details[0]['seo_desc']; }?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                            <a href="<?= site_url() . DASHBOARD_DIR_NAME ?>settings/topics" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                                        </form>
                                    </div>                                    
                                </div>
                            </section>
                        </section>
                        <script>                            
                            $(".topic_form").submit(function(e){
                                pills = $('#MyPillbox').pillbox('items');
                                if(pills.length>0){
                                    $("#seo_keywords").val(JSON.stringify(pills));
                                }                                        
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.topic_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/settings/save_topic_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>settings/topics/";
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
                            
                            $(".topic_name").bind("keyup change", function(e) {
                                name = $(".topic_name").val();
                                name = name.toLowerCase();
                                slug = name.replace(/[^A-Z0-9]+/ig, "-");
                                //$(".topic_url").val(slug);
                            });

                            $(".topic_url").bind("keyup change", function(e) {
                                $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                            });                        
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
