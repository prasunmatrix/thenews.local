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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/menu_items"><i class="fa fa-list-ol"></i> &nbsp;<?= lang('menu_items'); ?></a></li>
                                    <?php
                                        if($this->uri->segment(5)=='add'){
                                    ?>
                                        <li class="active"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_menu_item'); ?></li>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_menu_item_details'); ?></li>
                                    <?php        
                                        }
                                    ?>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="menu_items_form">
                                            <div class="col-md-8">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php
                                                            if($this->uri->segment(5)=='add'){
                                                        ?>
                                                            <i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_menu_item'); ?>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_menu_item_details'); ?>
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
                                                                <input type="hidden" name="item_id" class="form-control" value="<?php  if(isset($menu_item_details[0]['item_id'])){ echo $menu_item_details[0]['item_id']; }?>">
                                                                <input type="text" name="item_title" class="form-control item_title" placeholder="<?= lang('item_title'); ?>" value="<?php  if(isset($menu_item_details[0]['item_title'])){ echo $menu_item_details[0]['item_title']; }?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </div>
                                                                <input type="text" name="item_url" class="form-control item_url" placeholder="<?= lang('item_url'); ?>" value="<?php  if(isset($menu_item_details[0]['rand_id'])){ echo $menu_item_details[0]['rand_id']; }?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <?= site_url(); ?>
                                                                </div>
                                                                <input type="text" name="item_href" class="form-control" placeholder="<?= lang('item_href'); ?>" value="<?php  if(isset($menu_item_details[0]['item_href'])){ echo $menu_item_details[0]['item_href']; }?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-font-awesome"></i>
                                                                </div>
                                                                <input type="text" name="item_icon" class="form-control" placeholder="<?= lang('item_icon'); ?>" value="<?php  if(isset($menu_item_details[0]['item_icon'])){ echo $menu_item_details[0]['item_icon']; }?>">
                                                            </div>
                                                        </div>                                                    
                                                        
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                            <a href="#" onclick="history.back()" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                            $(document).ready(function(){
                                $(".item_title").focus();
                            });
                            $(".menu_items_form").submit(function(e){
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.menu_items_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/settings/save_menu_item_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>settings/menu_items/";
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
                            
                            $(".item_title").bind("keyup change", function(e) {
                                name = $(".item_title").val();
                                name = name.toLowerCase();
                                slug = name.replace(/[^A-Z0-9]+/ig, "-");
                                $(".item_url").val(slug);
                            });

                            $(".item_url").bind("keyup change", function(e) {
                                $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                            });                        
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
