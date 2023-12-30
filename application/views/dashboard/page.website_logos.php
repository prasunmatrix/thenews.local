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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings"><i class="fa fa-cog"></i> &nbsp;<?= lang('general_settings'); ?></a></li>
                                    <li class="active"><i class="fa fa-image"></i> &nbsp;<?= lang('website_logos'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-default ">
                                            <div class="panel-heading"><i class="fa fa-image"></i> &nbsp;<?= lang('website_logos'); ?></div>
                                            <div class="panel-body">
                                                <div class="col-md-12 no_padding">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='logo_white'){
                                                                    $last_modified_date = $config['date_modified'];
                                                                    $last_modified_by = $config['user_modified'];
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <?= lang('white_logo'); ?>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                    $file_name = $config['config_value'];                        
                                                                ?>
                                                                <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $file_name; ?>" class="img-responsive"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='logo_black'){
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <?= lang('black_logo'); ?>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                    $file_name = $config['config_value'];                        
                                                                ?>
                                                                <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $file_name; ?>" class="img-responsive"/>
                                                            </div>
                                                        </div>
                                                    </div>                                                        
                                                    <?php
                                                                }
                                                                if($config['config_name']=='favicon_icon'){
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <?= lang('favicon_icon'); ?>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                    $file_name = $config['config_value'];                        
                                                                ?>
                                                                <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $file_name; ?>" class="img-responsive"/>
                                                            </div>
                                                        </div>
                                                    </div>                                                        
                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12 no_padding">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                    <?php
                                                        if($this->permissions_model->check('website_logos','edit')){
                                                    ?>
                                                        <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/website_logos/edit"><i class="fa fa-pencil"></i></a></span>
                                                    <?php
                                                        }
                                                    ?>

                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-12" style="padding: 0px;">
                                                        <div class="col-md-5">
                                                            <p class="pull-right"><?= lang('last_updated'); ?></p>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <strong><?php if(isset($last_modified_date)){ echo date('M d,Y h:i A',$last_modified_date); } else{ echo '--'; } ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding: 0px;">
                                                        <div class="col-md-5">
                                                            <p class="pull-right"><?= lang('updated_by'); ?></p>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <?php
                                                                if(isset($last_modified_by)) {
                                                                    $client_details = $this->users_model->get_where('users',array('user_id'=>$last_modified_by));
                                                                    $name = "";
                                                                    if(!empty($client_details)){
                                                                        $name = "<strong>".$client_details[0]['first_name'] . ' ' . $client_details[0]['last_name']."</strong>";
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
                                        <div class="col-md-12 no_padding">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?>
                                                </div>
                                                <div class="panel-body">
                                                    <ul>
                                                        <li><?= lang('website_logo_instruction_1'); ?></li>
                                                        <li><?= lang('website_logo_instruction_2'); ?></li>
                                                        <li><?= lang('website_logo_instruction_3'); ?></li>
                                                        <li><?= lang('website_logo_instruction_4'); ?></li>
                                                        <li><?= lang('website_logo_instruction_5'); ?></li>
                                                        <li><?= lang('website_logo_instruction_6'); ?></li>
                                                    </ul>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>                           
                    </section>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>