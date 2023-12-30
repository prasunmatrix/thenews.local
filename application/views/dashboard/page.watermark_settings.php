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
                                    <li class="active"><i class="fa fa-image"></i> &nbsp;<?= lang('watermark_settings'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <i class="fa fa-image"></i> &nbsp;<?= lang('watermark_settings'); ?>
                                                 <?php
                                                    if($this->permissions_model->check('watermark_settings','edit')){
                                                ?>
                                                    <span class="pull-right"><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/watermark_settings/edit"><i class="fa fa-pencil"></i></a></span>
                                                <?php
                                                    }
                                                ?>
                                            
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                    if(!empty($general_config)){
                                                        $configs = array();
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                $last_modified_date = $config['date_modified'];
                                                                $last_modified_by = $config['user_modified'];
                                                                $configs[$config['config_name']] = $config['config_value'];
                                                            }
                                                        }   
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                        <p class="pull-right"><?= lang('watermark_type'); ?></p>
                                                    </div>
                                                    <div class="col-md-4"><?php if($configs['watermark_type']!=""){ echo lang($configs['watermark_type']); } else{ echo "--"; } ?></div>
                                                </div>
                                                <div class="watermark_type_image" <?php if($configs['watermark_type']=='text'){ echo " style='display:none;' "; } ?>>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('large_thumbnail_watermark_image'); ?></p>
                                                        </div>
                                                        <?php
                                                            $file_name = $configs['watermark_large_thumb_image'];
                                                             
                                                        ?>
                                                        <div class="col-md-4"><img src="/public_html/upload/images/<?= $file_name; ?>" class="img-responsive"/></div>
                                                    </div>
                                                </div>
                                                <div class="watermark_type_text" <?php if($configs['watermark_type']=='image'){ echo " style='display:none;' "; } ?>>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('large_thumb_watermark_text'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_large_thumn_text']!=""){ echo $configs['watermark_large_thumn_text']; } else{ echo "--"; } ?></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('large_thumb_watermark_font_size'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_large_thumb_font_size']!=""){ echo $configs['watermark_large_thumb_font_size']; } else{ echo "--"; } ?></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('large_thumb_watermark_font_color'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_large_thumb_font_color']!=""){ echo "<p style='color:".$configs['watermark_large_thumb_font_color']."'>Watermark Text</p>"; } else{ echo "--"; } ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                        <p class="pull-right"><?= lang('large_thumb_watermark_vertical_allignment'); ?></p>
                                                    </div>
                                                    <div class="col-md-4"><?php if($configs['watermark_large_thumb_vertical_align']!=""){ echo lang($configs['watermark_large_thumb_vertical_align']); } else{ echo "--"; } ?></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                        <p class="pull-right"><?= lang('large_thumb_watermark_horizontal_allignment'); ?></p>
                                                    </div>
                                                    <div class="col-md-4"><?php if($configs['watermark_large_thumb_horizontal_align']!=""){ echo lang($configs['watermark_large_thumb_horizontal_align']); } else{ echo "--"; } ?></div>
                                                </div>
                                                <div class="watermark_type_image" <?php if($configs['watermark_type']=='text'){ echo " style='display:none;' "; } ?>>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('small_thumbnail_watermark_image'); ?></p>
                                                        </div>
                                                         <?php
                                                            $file_name = $configs['watermark_small_thumb_image'];
                                                        ?>
                                                        <div class="col-md-4"><img src="/public_html/upload/images/<?= $file_name; ?>" class="img-responsive"/></div>
                                                    </div>
                                                </div>
                                                <div class="watermark_type_text" <?php if($configs['watermark_type']=='image'){ echo " style='display:none;' "; } ?>>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('small_thumb_watermark_text'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_small_thumb_text']!=""){ echo $configs['watermark_small_thumb_text']; } else{ echo "--"; } ?></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('small_thumb_watermark_font_size'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_small_thumb_font_size']!=""){ echo $configs['watermark_small_thumb_font_size']; } else{ echo "--"; } ?></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <p class="pull-right"><?= lang('small_thumb_watermark_font_color'); ?></p>
                                                        </div>
                                                        <div class="col-md-4"><?php if($configs['watermark_small_thumb_font_color']!=""){ echo "<p style='color:".$configs['watermark_small_thumb_font_color']."'>Watermark Text</p>"; } else{ echo "--"; } ?></div>
                                                    </div>
                                                </div>                                                    
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                        <p class="pull-right"><?= lang('small_thumb_watermark_vertical_allignment'); ?></p>
                                                    </div>
                                                    <div class="col-md-4"><?php if($configs['watermark_small_thumb_vertical_align']!=""){ echo lang($configs['watermark_small_thumb_vertical_align']); } else{ echo "--"; } ?></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                        <p class="pull-right"><?= lang('small_thumb_watermark_horizontal_allignment'); ?></p>
                                                    </div>
                                                    <div class="col-md-4"><?php if($configs['watermark_small_thumb_horizontal_align']!=""){ echo lang($configs['watermark_small_thumb_horizontal_align']); } else{ echo "--"; } ?></div>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?>
                                                </div>
                                                <div class="panel-body">
                                                    <p><?= lang('when_we_upload_a_image_on_the_server_there_are_two_new_images_will_be_generated_for_display_in_the_website_you_can_set_watermark_settings_as_per_your_requirments_for_both_images'); ?></p>
                                                    <p><?= lang('dictionary'); ?></p>
                                                    <p><?= lang('vertical_alignment'); ?>: <strong>Vertical Alignment</strong></p>
                                                    <p><?= lang('horizontal_alignment'); ?>: <strong>Horizontal Alignment</strong></p>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-gear"></i> &nbsp;<?= lang('settings'); ?>
                                                </div>
                                                <div class="panel-body">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='watermark_in_album'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_to_image_in_the_album'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                        </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='watermark_in_event'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_to_image_in_the_event'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                        </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='watermark_in_home_page_gallery'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_to_image_in_the_home_gallery'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                        </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='watermark_in_home_page_slider'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_to_image_in_the_home_slider'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                        </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='watermark_in_text_editor'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_to_image_in_editor'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                        </div>
                                                    <?php
                                                                }
                                                                if($config['config_name']=='watermark_in_entity_thumbnail'){
                                                    ?>
                                                        <div class="col-md-12" style="padding-left: 0px;">
                                                            <div class="col-xs-10" style="padding-left: 0px;">
                                                                <p class="pull-right"><?= lang('add_watermark_in_entity_thumbnail'); ?></p>
                                                            </div>
                                                            <div class="col-xs-2"><label class='switch'><input onchange='change_watermark_settings(<?= $config['config_id']; ?>)' type='checkbox' id="watermark_<?= $config['config_id']; ?>" <?php if($config['config_value']=='1'){ echo "checked"; } ?>><span></span></label></div>
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
                                </div>
                            </section>
                        </section>                           
                    </section>
        <script>
            <?php
                if($this->permissions_model->check('watermark_settings','edit')){
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
            function change_watermark_settings(per){
                if ($('#watermark_'+per).prop('checked')){
                    permission = "1";
                }
                else{
                    permission = "0";
                }
                console.log(permission);
                $.ajax({
                    data: {permission:permission, per:per},
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/general_settings/change_watermark_permission_details",
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