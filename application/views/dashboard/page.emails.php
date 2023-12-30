<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'_head.php');
?>

    </head>
    <body>
        <?php
            $this->load->view(DASHBOARD_DIR_NAME.'block.head.php');
        ?>
            
                    <section id="content">
                        <section class="vbox">          
                            <section class="scrollable padder">
                                <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('home'); ?></a></li>
                                    <li class="active"><i class="fa fa-envelope-o"></i> &nbsp;<?= lang('emails'); ?></li>
                                </ul>
                                <section class="panel panel-default" style="margin-top: 10px;">
                                    <header class="panel-heading">
                                        <i class="fa fa-envelope-o"></i> &nbsp;<?= lang('emails'); ?>
                                    </header>
                                    <div class="table-responsive">
                                        <table class="table table-striped m-b-none emails_datatable">
                                            <thead>
                                                <tr>
                                                    <th style="max-width: 70px"><?= lang('sr_no'); ?></th>
                                                    <th><?= lang('to'); ?></th>
                                                    <th><?= lang('subject'); ?></th>
                                                    <th><?= lang('datetime'); ?></th>
                                                    <th style="max-width: 80px"><?= lang('actions'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>                                                                
                            </section>
                        </section>                           
                    </section>
                    <script>
                        $(document).ready(function(e){
                            get_emails_datatable();
                        });
                        function get_emails_datatable(){
                            table = $('.emails_datatable').DataTable({ 
                                "processing": true, 
                                "serverSide": true,
                                "destroy" : true,
                                "searching" : true,
                                "stateSave": true,

                                "ajax": {
                                   "url": "<?= site_url(); ?>api/emails/list_emails_datatable",
                                   "type": "POST"
                                },
                                "columnDefs": [
                                    { 
                                        "targets": [ 4 ],                     
                                        "orderable": false, 
                                    },
                                ],
                            });
                            $(".emails_datatable_paginate").css("margin-top","0px");
                            $(".dataTables_length").addClass('col-xs-6');
                            $(".dataTables_info").addClass('col-xs-6');
                        }
                   </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>