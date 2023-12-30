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
                                    <li class="active"><i class="fa fa-envelope-o"></i> &nbsp;<?= lang('email_settings'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                    if(!empty($email_settings)){
                                                        foreach($email_settings as $config){
                                                            if($config['config_name']=='send_email_to_new_subscription'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_email_to_new_subscription'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_a_thanks_email_when_someone_contact_us'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_a_thanks_email_when_someone_contact_us'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_when_new_user_register'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_when_new_user_register'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_blog_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_blog_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_blog_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_blog_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_reminder_is_added'){
                                                ?>
<!--                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_reminder_is_added'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>-->
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_reminder_is_added'){
                                                ?>
<!--                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_reminder_is_added'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>-->
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_service_is_added'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_service_is_added'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_service_is_added'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_service_is_added'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_video_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_video_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_video_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_video_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_live_streaming_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_live_streaming_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_live_streaming_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_live_streaming_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_users_when_new_event_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_users_when_new_event_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_subscribers_when_new_event_is_published'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_subscribers_when_new_event_is_published'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_the_user_when_an_album_is_created_for_him'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_the_user_when_an_album_is_created_for_him'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_an_email_to_all_the_admins_when_new_booking'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_an_email_to_all_the_admins_when_new_booking'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                    </div>
                                                <?php
                                                            }
                                                            if($config['config_name']=='send_a_thanks_email_to_the_user_when_new_booking'){
                                                ?>
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <div class="col-xs-10" style="padding-left: 0px;">
                                                            <p class="pull-right"><?= lang('send_a_thanks_email_to_the_user_when_new_booking'); ?></p>
                                                        </div>
                                                        <div class="col-xs-2"><label class='switch'><input onchange='change_email_settings(<?= $config['config_id']; ?>)' type='checkbox' id="email_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
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
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?>
                                                </div>
                                                <div class="panel-body">
                                                    <p><?= lang('using_email_settings_ou_can_manager_all_the_emails_sending_from_the_system'); ?></p>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>                           
                    </section>
        <script>
            <?php
                if($this->permissions_model->check('email_settings','edit')){
                    ?>
                        $(document).ready(function(){
                            $("input[type=checkbox]").prop('disabled',false);
                        });
                    <?php
                }
                else{
                    ?>
                        $(document).ready(function(){
                            $("input[type=checkbox]").prop('disabled',true);
                        });
                    <?php
                }
            ?>
            function change_email_settings(per){
                if ($('#email_'+per).prop('checked')){
                    permission = "1";
                }
                else{
                    permission = "0";
                }
                $.ajax({
                    data: {permission:permission, per:per},
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/general_settings/update_email_settings",
                    success: function (data) {
                        if(data.status){
                            alertify.notify(data.message, 'success', 5, function(){  console.log('dismissed'); });
                        }
                        else{
                            alertify.notify(data.message, 'warning', 5, function(){  console.log('dismissed'); });
                        }
                    }
                });
            }
        </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>