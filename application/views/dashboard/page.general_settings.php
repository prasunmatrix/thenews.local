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
                                    <li class="active"><i class="fa fa-gear"></i> &nbsp;<?= lang('general_settings'); ?></li>
                                </ul>
                                <section class="panel panel-default" style="margin-top: 20px;">
                                    <div class="row m-l-none m-r-none bg-light lter">
                                        <?php
                                            if($this->permissions_model->check('watermark_settings','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-info"></i>
                                                <i class="fa fa-image fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="3000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/watermark_settings">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('watermark_settings'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                            if($this->permissions_model->check('email_signature','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                <i class="fa fa-envelope-o fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#fff" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="4000" data-target="#bugs" data-update="3000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/email_signature">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('email_signature'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                            if($this->permissions_model->check('date_format','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light">                     
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                <i class="fa fa-calendar-o fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="5000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/date_format">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('date_and_time_settings'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                            if($this->permissions_model->check('website_logos','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <i class="fa fa-image fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="6000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/website_logos">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('website_logos'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="row m-l-none m-r-none bg-light lter">
                                        <?php
                                            if($this->permissions_model->check('social_links','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <i class="fa fa-facebook fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#fff" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="4000" data-target="#bugs" data-update="3000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/social_links">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('social_links'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                            if($this->permissions_model->check('google_analytics','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light">                     
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                <i class="fa fa-google fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="5000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_analytics">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('google_analytics'); ?></strong></span>
                                            </a>
                                        </div>                                        
                                        <?php
                                            }
                                            if($this->permissions_model->check('google_adsense','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-info"></i>
                                                <i class="fa fa-google-wallet fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="6000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_adsense">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('google_adsense'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                            if($this->permissions_model->check('languages','index')){
                                        ?>
                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-info"></i>
                                                <i class="fa fa-language fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="3000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/languages">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('languages'); ?></strong></span>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="row m-l-none m-r-none bg-light lter">
                                        <?php
                                            if($this->permissions_model->check('email_settings','index')){
                                        ?>
<!--                                        <div class="col-sm-6 col-md-3 padder-v b-r b-light ">
                                            <span class="fa-stack fa-2x pull-left m-r-sm">
                                                <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                <i class="fa fa-send fa-stack-1x text-white"></i>
                                                <span class="easypiechart pos-abt" data-percent="100" data-line-width="4" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="50" data-line-cap='butt' data-animate="3000" data-update="5000"></span>
                                            </span>
                                            <a class="clear" href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/email_settings">
                                                <span class="h3 block m-t-xs-settings"><strong><?= lang('email_settings'); ?></strong></span>
                                            </a>
                                        </div>-->
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </section>
                                
                            </section>
                        </section>                           
                    </section>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>