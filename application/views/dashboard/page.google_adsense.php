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
                                    <li class="active"><i class="fa fa-google"></i> &nbsp;<?= lang('google_adsense'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><i class="fa fa-google"></i> &nbsp;<?= lang('google_adsense'); ?></div>
                                            <div class="panel-body">
                                                <?php
                                                    if(!empty($general_config)){
                                                        foreach($general_config as $config){
                                                            if($config['config_name']=='adsense_code'){
                                                                $last_modified_date = $config['date_modified'];
                                                                $last_modified_by = $config['user_modified'];
                                                ?>
                                                <div class="col-md-12">
                                                    
                                                    <?php 
                                                        $adsense_value = "xxxxxxxxxxxxxxxx";
                                                        if($config['config_value']!=""){ 
                                                            $adsense_value = $config['config_value'];                                                             
                                                        } 
                                                    ?>
                                                    &nbsp; &nbsp; &nbsp; &lt;script  async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"&gt;&lt;/script&gt;<br>
                                                    &nbsp; &nbsp; &nbsp; &lt;script&gt;<br>
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (adsbygoogle = window.adsbygoogle || []).push({<br>
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; google_ad_client: "ca-pub-<span style="color:red;"><?= $adsense_value; ?></span>",<br>
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; enable_page_level_ads: true<br>
                                                            &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; });<br>
                                                    &nbsp; &nbsp; &nbsp; &lt;/script&gt;
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
                                                        if($this->permissions_model->check('google_adsense','edit')){
                                                    ?>
                                                        <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_adsense/edit"><i class="fa fa-pencil"></i></a></span>
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
                                                    <strong><p><?= lang('general_instructions'); ?></p></strong>
                                                    <ul>
                                                        <li><?= lang('you_google_adsense_code_look_like_this'); ?></li>
                                                        <li><?= lang('you_can_not_modify_the_entire_google_adsense_code_due_to_security_reasons'); ?></li>
                                                        <li><?= lang('for_enable_your_google_adsense_account_you_can_edit_google_ad_client_in_this_code'); ?></li>
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