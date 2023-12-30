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
                                    <li class="active">&nbsp;<?php if(isset($menu_item_details[0]['item_title'])){ echo $menu_item_details[0]['item_title']; } ?></li>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding" style="margin-bottom: 10px;">
                                        <a href="#" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#subItemsModal"><?= lang('add_new_menu_sub_item'); ?></a>
                                    </div>
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="news_type_form">
                                            <div class="col-md-9 no-padding">
                                                <section class="panel panel-default no-padding" style="margin-top: 10px;">
                                                    <header class="panel-heading">
                                                        <i class="fa fa-newspaper-o"></i> &nbsp;<?= sprintf(lang('sub_menus_of'),$menu_item_details[0]['item_title']); ?>
                                                    </header>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped m-b-none menu_sub_items_datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th style="max-width: 70px"><?= lang('sr_no'); ?></th>
                                                                    <th><?= lang('item_title'); ?></th>
                                                                    <th><?= lang('author'); ?></th>
                                                                    <th><?= lang('published_date'); ?></th>
                                                                    <th style="max-width: 80px"><?= lang('actions'); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                            <?php
                                                                if($this->permissions_model->check('menu_items','edit')){                
                                                            ?>
                                                                <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/menu_items/edit/<?= $menu_item_details[0]['rand_id']; ?>"><i class="fa fa-pencil"></i></a></span>
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
                                                                        if($menu_item_details[0]['user_created']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$menu_item_details[0]['user_created']));
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
                                                                    <strong><?= $menu_item_details[0]['date_created'] ? date('M d,Y h:i A',$menu_item_details[0]['date_created']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('last_updated'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong><?= $menu_item_details[0]['date_modified'] ? date('M d,Y h:i A',$menu_item_details[0]['date_modified']) : '--'; ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <div class="col-md-5">
                                                                    <p class="pull-right"><?= lang('updated_by'); ?></p>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                        if($menu_item_details[0]['user_modified']) {
                                                                            $user_details = $this->users_model->get_where('users',array('user_id'=>$menu_item_details[0]['user_modified']));
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal -->
                                    <div id="subItemsModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <form class="menu_sub_items_form" method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title"><?= sprintf(lang('add_new_sub_item_under'),$menu_item_details[0]['item_title']); ?></h4>
                                                    </div>                                                
                                                    <div class="modal-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="hidden" name="sub_item_id" class="form-control sub_item_id">
                                                                <input type="hidden" name="parent_item_id" class="form-control" value="<?= $menu_item_details[0]['item_id']; ?>">
                                                                <input type="text" name="sub_item_title" class="form-control sub_item_title" placeholder="<?= lang('sub_item_title'); ?>" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </div>
                                                                <input type="text" name="sub_item_url" class="form-control sub_item_url" placeholder="<?= lang('sub_item_url'); ?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <?= site_url() ?>
                                                                </div>
                                                                <input type="text" name="sub_item_href" class="form-control sub_item_href" placeholder="<?= lang('sub_item_href'); ?>">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-font-awesome"></i>
                                                                </div>
                                                                <input type="text" name="sub_item_icon" class="form-control sub_item_icon" placeholder="<?= lang('sub_item_icon'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="border-top:none;">
                                                        <button type="submit" class="btn btn-dark btn-sm submit_btn"><?= lang('save'); ?></button>
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?= lang('cancel'); ?></button>
                                                    </div>
                                                </form>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>
                        <script>                            
                            $(document).ready(function(e){
                                get_menu_sub_items_datatable();
                            });
                            function get_menu_sub_items_datatable(){
                                table = $('.menu_sub_items_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,

                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/settings/list_menu_sub_items_datatable",
                                       "type": "POST",
                                       "data":{item_id:<?= $menu_item_details[0]['item_id']; ?>}
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [ 0,4 ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".list_menu_sub_items_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                            <?php
                                if($this->permissions_model->check('menu_items','delete')){
                            ?>
                                function delete_menu_sub_item(id){
                                    if(id){
                                        alertify.confirm("<?= lang('are_you_sure'); ?>", "<?= lang('do_you_want_to_delete_menu_sub_item'); ?>", function(){
                                            $.ajax({
                                                data: {id:id},
                                                type: "post",
                                                dataType: 'json',
                                                url: "<?= site_url() ?>api/settings/delete_menu_sub_item_details",
                                                success: function (data) {
                                                    if (data.status) {
                                                        alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                            get_menu_sub_items_datatable();
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
                            <?php
                                if($this->permissions_model->check('sub_menu_items','edit')){
                            ?>
                                function edit_sub_menu_details(id){
                                    clear_sub_items_form();
                                    if(id){
                                        console.log(id);
                                        $.ajax({
                                            data: {id:id},
                                            type: "post",
                                            dataType: 'json',
                                            url: "<?= site_url() ?>api/settings/get_sub_item_details",
                                            success: function (data) {
                                                if (data.length === 0) {
                                                     alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                                    }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                                }
                                                else{
                                                    $(".sub_item_id").val(data[0].sub_item_id);
                                                    $(".sub_item_title").val(data[0].sub_item_title);
                                                    $(".sub_item_href").val(data[0].sub_item_href);
                                                    $(".sub_item_icon").val(data[0].sub_item_icon);
                                                    $(".sub_item_url").val(data[0].sub_rand_id);
                                                    $("#subItemsModal").modal('show');
                                                }
                                            }
                                        });
                                    }   
                                    else{
                                        console.log('Item could not be identified.');
                                    }
                                }            
                            <?php
                                }
                            ?>
                            function clear_sub_items_form(){
                                $(".sub_item_id").val('');
                                $(".sub_item_title").val('');
                                $(".sub_item_href").val('');
                                $(".sub_item_icon").val('');
                                $(".sub_item_url").val('');
                            }
                            $(".menu_sub_items_form").submit(function(e){
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.menu_sub_items_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/settings/save_menu_sub_item_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                $("#subItemsModal").modal('hide');
                                                clear_sub_items_form();
                                                get_menu_sub_items_datatable();
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
                            
                            $(".sub_item_title").bind("keyup change", function(e) {
                                name = $(".sub_item_title").val();
                                name = name.toLowerCase();
                                slug = name.replace(/[^A-Z0-9]+/ig, "-");
                                //$(".sub_item_url").val(slug);
                            });

                            $(".sub_item_url").bind("keyup change", function(e) {
                                $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                            });                        
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
