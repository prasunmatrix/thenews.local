<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php  $this->load->view('dashboard/_head.php'); ?>

    </head>
    <body class="">
    <?php $this->load->view('dashboard/block.head.php'); ?>
        
<?php } ?>
                        <title><?php echo $page_title; ?> - <?php echo lang('site_title'); ?></title>
                        <section class="vbox bg-gradient content-vbox">
                            <header class="header b-b b-t b-light bg-light lter">
                                <p class="font-bold"><?= $page_title ?></p>
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <a href="<?= site_url().DASHBOARD_DIR_NAME.'news_types/add'?>" class="btn btn-dark"><?= lang('add_new_news_type'); ?></a>
                                    </div>
                                    <div class="col-md-12 no-padding">
                                        <section class="panel panel-default no-padding" style="margin-top: 10px;">
                                            <header class="panel-heading">
                                                <i class="fa fa-newspaper-o"></i> &nbsp;<?= lang('news_types'); ?>
                                            </header>
                                            <div class="table-responsive">
                                                <table class="table table-striped m-b-none news_types_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th style="max-width: 120px"><?= lang('sr_no'); ?></th>
                                                            <th><?= lang('news_type'); ?></th>
                                                            <th><?= lang('total_news'); ?></th>
                                                            <th><?= lang('author'); ?></th>
                                                            <th><?= lang('published_date'); ?></th>
                                                            <th style="max-width: 180px"><?= lang('actions'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                    </div>                                    
                                </div>
                            </section>
                        </section>
                        <script>                            
                            $(document).ready(function(e){
                                get_news_types_datatable();
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
                                            "targets": [ 0,2,3,5 ],                     
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
                                function delete_news_type(id){
                                    if(id){
                                        alertify.confirm("<?= lang('are_you_sure'); ?>", "<?= lang('do_you_want_to_delete_news_type'); ?>", function(){
                                            $.ajax({
                                                data: {id:id},
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
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
