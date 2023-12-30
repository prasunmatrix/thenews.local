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
                                    <li class="active"><i class="fa fa-calendar-o"></i> &nbsp;<?= lang('date_and_time_settings'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><i class="fa fa-calendar-o"></i> &nbsp;<?= lang('date_and_time_settings'); ?></div>
                                            <div class="panel-body">
                                                  <?php
                                                    if(!empty($general_config)){
                                                        foreach($general_config as $config){
                                                            if($config['config_name']=='date_format'){
                                                                $last_modified_date = $config['date_modified'];
                                                                $last_modified_by = $config['user_modified'];
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
                                                        <p class="pull-right"><?= lang('date_format'); ?></p>
                                                    </div>
                                                    <div class="col-md-9"><?php if($config['config_value']!=""){ echo date($config['config_value'],now()); } else{ echo "--"; } ?></div>
                                                </div>
                                                <?php                
                                                            }                                                    
                                                            if($config['config_name']=='time_format'){
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
                                                        <p class="pull-right"><?= lang('time_format'); ?></p>
                                                    </div>
                                                    <div class="col-md-9"><?php if($config['config_value']!=""){ echo date($config['config_value'],now()); } else{ echo "--"; } ?></div>
                                                </div>
                                                <?php                
                                                            }                                                                                                                                                                    
                                                            if($config['config_name']=='timezone'){
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
                                                        <p class="pull-right"><?= lang('time_zone'); ?></p>
                                                    </div>
                                                    <div class="col-md-9"><?php if($config['config_value']!=""){ echo $config['config_value']; } else{ echo "--"; } ?></div>
                                                </div>
                                                <?php                
                                                            }                                                                                                                                                                    
                                                        }                                                    
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                    <?php
                                                        if($this->permissions_model->check('date_format','edit')){
                                                    ?>
                                                        <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/date_format/edit"><i class="fa fa-pencil"></i></a></span>
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
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?>


                                                </div>
                                                <div class="panel-body">
                                                    <?= lang('given_date_and_time_format_will_be_applicable_in_the_entire_website'); ?>
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