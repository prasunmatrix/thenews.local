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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('dashboard'); ?></a></li>
                                    <li class="active"><i class="fa fa-user-md"></i> &nbsp;<?= lang('profile'); ?></li>
                                </ul>
                                <div class="col-md-12">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-6">
                                        <img src="/public_html/images/underconstruction.png" class="img-responsive"/>
                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                </div>                                
                            </section>
                        </section>                           
                    </section>                    
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>