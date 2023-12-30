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
                                                <i class="fa fa-code"></i> &nbsp;<?= lang('system_logs'); ?>
                                            </header>
                                            <div class="table-responsive">
                                                <table class="table table-striped m-b-none system_logs_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th style="max-width: 70px"><?= lang('log_id'); ?></th>
                                                            <th><?= lang('operation'); ?></th>
                                                            <th><?= lang('log_type'); ?></th>
                                                            <th><?= lang('ip'); ?></th>
                                                            <th><?= lang('os'); ?></th>
                                                            <th><?= lang('url'); ?></th>
                                                            <th><?= lang('browser'); ?></th>
                                                            <th><?= lang('user_name'); ?></th>
                                                            <th><?= lang('datetime'); ?></th>
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
                                get_system_logs_datatable();
                            });
                            function get_system_logs_datatable(){
                                table = $('.system_logs_datatable').DataTable({ 
                                    "processing": true, 
                                    "serverSide": true,
                                    "destroy" : true,
                                    "searching" : true,
                                    "stateSave": true,
                                    "ajax": {
                                       "url": "<?= site_url(); ?>api/systems/list_system_logs_datatable",
                                       "type": "POST"
                                    },
                                    "columnDefs": [
                                        { 
                                            "targets": [  ],                     
                                            "orderable": false, 
                                        },
                                    ],
                                });
                                $(".system_logs_datatable_paginate").css("margin-top","0px");
                                $(".dataTables_length").addClass('col-xs-6');
                                $(".dataTables_info").addClass('col-xs-6');
                            }
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
