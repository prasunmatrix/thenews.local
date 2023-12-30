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
                                        <section class="panel panel-default no-padding" style="margin-top: 10px;">
                                            <header class="panel-heading">
                                                <i class="fa fa-users"></i> &nbsp;<?= lang('users'); ?>
                                            </header>
                                            <div class="table-responsive">
                                                <table class="table table-striped m-b-none users_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th style="max-width: 120px"><?= lang('sr_no'); ?></th>
                                                            <th><?= lang('user_name'); ?></th>
                                                            <th><?= lang('email'); ?></th>
                                                            <th><?= lang('user_role'); ?></th>
                                                            <th><?= lang('subscribption_end_date'); ?></th>
                                                            <th style="max-width: 70px"><?= lang('actions'); ?></th>
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
                                get_users_datatable();
                            });
                            function get_users_datatable(){
                                table = $('.users_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,
                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/users/list_users_datatable",
                                       "type": "POST"
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [ 5 ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".users_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
