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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings"><i class="fa fa-gear"></i> &nbsp;<?= lang('general_settings'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/watermark_settings"><i class="fa fa-image"></i> &nbsp;<?= lang('watermark_settings'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_watermark_settings'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="watermark_settings_form">                                        
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-image"></i> &nbsp;<?= lang('edit_watermark_settings'); ?></div>
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
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('watermark_type'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-sitemap"></i>
                                                            </div>
                                                            <select class="form-control watermark_type" name="watermark_type">
                                                                <option value="" disabled selected><?= lang('watermark_type'); ?></option>
                                                                <option value="text" <?php if($configs['watermark_type']=='text'){ echo "selected"; }?>><?= lang('text'); ?></option>
                                                                <option value="image" <?php if($configs['watermark_type']=='image'){ echo "selected"; }?>><?= lang('image'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="watermark_type_text" <?php if($configs['watermark_type']=='image'){ echo " style='display:none;' "; } ?>>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group" data-toggle="tooltip" title="<?= lang('large_thumb_watermark_text'); ?>" data-placement="top">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-pencil"></i>
                                                                </div>
                                                                <input type="text" name="large_thumb_watermark_text" placeholder="<?= lang('large_thumb_watermark_text'); ?>" class="form-control" value="<?php if($configs['watermark_large_thumn_text']!=""){ echo $configs['watermark_large_thumn_text']; } ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="padding: 0px 5px 0px 0px;margin-bottom: 10px;">
                                                            <div class="input-group" data-toggle="tooltip" title="<?= lang('large_thumb_watermark_font_size'); ?>" data-placement="top">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-font"></i>
                                                                </div>
                                                                <select class="form-control" name="large_thumb_watermark_font_size">
                                                                    <option value="" disabled selected><?= lang('large_thumb_watermark_font_size'); ?></option>
                                                                    <option value="7" <?php if($configs['watermark_large_thumb_font_size']=='7'){ echo "selected"; }?>>7</option>
                                                                    <option value="8" <?php if($configs['watermark_large_thumb_font_size']=='8'){ echo "selected"; }?>>8</option>
                                                                    <option value="9" <?php if($configs['watermark_large_thumb_font_size']=='9'){ echo "selected"; }?>>9</option>
                                                                    <option value="10" <?php if($configs['watermark_large_thumb_font_size']=='10'){ echo "selected"; }?>>10</option>
                                                                    <option value="11" <?php if($configs['watermark_large_thumb_font_size']=='11'){ echo "selected"; }?>>11</option>
                                                                    <option value="12" <?php if($configs['watermark_large_thumb_font_size']=='12'){ echo "selected"; }?>>12</option>
                                                                    <option value="13" <?php if($configs['watermark_large_thumb_font_size']=='13'){ echo "selected"; }?>>13</option>
                                                                    <option value="14" <?php if($configs['watermark_large_thumb_font_size']=='14'){ echo "selected"; }?>>14</option>
                                                                    <option value="15" <?php if($configs['watermark_large_thumb_font_size']=='15'){ echo "selected"; }?>>15</option>
                                                                    <option value="16" <?php if($configs['watermark_large_thumb_font_size']=='16'){ echo "selected"; }?>>16</option>
                                                                    <option value="17" <?php if($configs['watermark_large_thumb_font_size']=='17'){ echo "selected"; }?>>17</option>
                                                                    <option value="18" <?php if($configs['watermark_large_thumb_font_size']=='18'){ echo "selected"; }?>>18</option>
                                                                    <option value="19" <?php if($configs['watermark_large_thumb_font_size']=='19'){ echo "selected"; }?>>19</option>
                                                                    <option value="20" <?php if($configs['watermark_large_thumb_font_size']=='20'){ echo "selected"; }?>>20</option>
                                                                    <option value="21" <?php if($configs['watermark_large_thumb_font_size']=='21'){ echo "selected"; }?>>21</option>
                                                                    <option value="22" <?php if($configs['watermark_large_thumb_font_size']=='22'){ echo "selected"; }?>>22</option>
                                                                    <option value="23" <?php if($configs['watermark_large_thumb_font_size']=='23'){ echo "selected"; }?>>23</option>
                                                                    <option value="24" <?php if($configs['watermark_large_thumb_font_size']=='24'){ echo "selected"; }?>>24</option>
                                                                    <option value="25" <?php if($configs['watermark_large_thumb_font_size']=='25'){ echo "selected"; }?>>25</option>
                                                                    <option value="26" <?php if($configs['watermark_large_thumb_font_size']=='26'){ echo "selected"; }?>>26</option>
                                                                    <option value="27" <?php if($configs['watermark_large_thumb_font_size']=='27'){ echo "selected"; }?>>27</option>                                                                
                                                                    <option value="28" <?php if($configs['watermark_large_thumb_font_size']=='28'){ echo "selected"; }?>>28</option>                                                                
                                                                    <option value="29" <?php if($configs['watermark_large_thumb_font_size']=='29'){ echo "selected"; }?>>29</option>                                                                
                                                                    <option value="30" <?php if($configs['watermark_large_thumb_font_size']=='30'){ echo "selected"; }?>>30</option>                                                                
                                                                    <option value="31" <?php if($configs['watermark_large_thumb_font_size']=='31'){ echo "selected"; }?>>31</option>                                                                
                                                                    <option value="32" <?php if($configs['watermark_large_thumb_font_size']=='32'){ echo "selected"; }?>>32</option>                                                                
                                                                    <option value="33" <?php if($configs['watermark_large_thumb_font_size']=='33'){ echo "selected"; }?>>33</option>                                                                
                                                                    <option value="34" <?php if($configs['watermark_large_thumb_font_size']=='34'){ echo "selected"; }?>>34</option>                                                                
                                                                    <option value="35" <?php if($configs['watermark_large_thumb_font_size']=='35'){ echo "selected"; }?>>35</option>                                                                
                                                                    <option value="36" <?php if($configs['watermark_large_thumb_font_size']=='36'){ echo "selected"; }?>>36</option>                                                                
                                                                    <option value="37" <?php if($configs['watermark_large_thumb_font_size']=='37'){ echo "selected"; }?>>37</option>                                                                
                                                                    <option value="38" <?php if($configs['watermark_large_thumb_font_size']=='38'){ echo "selected"; }?>>38</option>                                                                
                                                                    <option value="39" <?php if($configs['watermark_large_thumb_font_size']=='39'){ echo "selected"; }?>>39</option>                                                                
                                                                    <option value="40" <?php if($configs['watermark_large_thumb_font_size']=='40'){ echo "selected"; }?>>40</option>                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="padding: 0px 0px 0px 5px;margin-bottom: 10px;">
                                                            <div class="input-group" data-toggle="tooltip" title="<?= lang('large_thumb_watermark_font_color'); ?>" data-placement="top">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-paint-brush"></i>
                                                                </div>
                                                                <input type="color" name="large_thumb_watermark_font_color" placeholder="<?= lang('large_thumb_watermark_font_color'); ?>" class="form-control" value="<?php if($configs['watermark_large_thumb_font_color']!=""){ echo $configs['watermark_large_thumb_font_color']; } ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="watermark_type_image" <?php if($configs['watermark_type']=='text'){ echo " style='display:none;' "; } ?>>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <p><label for="watermark_large_thumb_image"><?= lang('upload_watermark_large_thumb_image'); ?></label></p>
                                                            <input type="file" id="watermark_large_thumb_image" name="watermark_large_thumb_image" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px 5px 0px 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('large_thumb_watermark_vertical_allignment'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-arrow-circle-down"></i>
                                                            </div>
                                                            <select class="form-control" name="large_thumb_watermark_vertical_allignment">
                                                                <option value="" disabled selected><?= lang('large_thumb_watermark_vertical_allignment'); ?></option>
                                                                <option value="top" <?php if($configs['watermark_large_thumb_vertical_align']=='top'){ echo "selected"; }?>><?= lang('top'); ?></option>
                                                                <option value="middle" <?php if($configs['watermark_large_thumb_vertical_align']=='middle'){ echo "selected"; }?>><?= lang('middle'); ?></option>                                                                
                                                                <option value="bottom" <?php if($configs['watermark_large_thumb_vertical_align']=='bottom'){ echo "selected"; }?>><?= lang('bottom'); ?></option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px 0px 0px 5px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('large_thumb_watermark_horizontal_allignment'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-arrow-circle-up"></i>
                                                            </div>
                                                            <select class="form-control" name="large_thumb_watermark_horizontal_allignment">
                                                                <option value="" disabled selected><?= lang('large_thumb_watermark_horizontal_allignment'); ?></option>
                                                                <option value="left" <?php if($configs['watermark_large_thumb_horizontal_align']=='left'){ echo "selected"; }?>><?= lang('left'); ?></option>
                                                                <option value="center" <?php if($configs['watermark_large_thumb_horizontal_align']=='center'){ echo "selected"; }?>><?= lang('center'); ?></option>                                                                
                                                                <option value="right" <?php if($configs['watermark_large_thumb_horizontal_align']=='right'){ echo "selected"; }?>><?= lang('right'); ?></option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="watermark_type_text" <?php if($configs['watermark_type']=='image'){ echo " style='display:none;' "; } ?>>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('small_thumb_watermark_text'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-pencil"></i>
                                                            </div>
                                                            <input type="text" name="small_thumb_watermark_text" placeholder="<?= lang('small_thumb_watermark_text'); ?>" class="form-control" value="<?php if($configs['watermark_small_thumb_text']!=""){ echo $configs['watermark_small_thumb_text']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px 5px 0px 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('small_thumb_watermark_font_size'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-font"></i>
                                                            </div>
                                                            <select class="form-control" name="small_thumb_watermark_font_size">
                                                                <option value="" disabled selected><?= lang('small_thumb_watermark_font_size'); ?></option>
                                                                <option value="7" <?php if($configs['watermark_small_thumb_font_size']=='7'){ echo "selected"; }?>>7</option>
                                                                <option value="8" <?php if($configs['watermark_small_thumb_font_size']=='8'){ echo "selected"; }?>>8</option>
                                                                <option value="9" <?php if($configs['watermark_small_thumb_font_size']=='9'){ echo "selected"; }?>>9</option>
                                                                <option value="10" <?php if($configs['watermark_small_thumb_font_size']=='10'){ echo "selected"; }?>>10</option>
                                                                <option value="11" <?php if($configs['watermark_small_thumb_font_size']=='11'){ echo "selected"; }?>>11</option>
                                                                <option value="12" <?php if($configs['watermark_small_thumb_font_size']=='12'){ echo "selected"; }?>>12</option>
                                                                <option value="13" <?php if($configs['watermark_small_thumb_font_size']=='13'){ echo "selected"; }?>>13</option>
                                                                <option value="14" <?php if($configs['watermark_small_thumb_font_size']=='14'){ echo "selected"; }?>>14</option>
                                                                <option value="15" <?php if($configs['watermark_small_thumb_font_size']=='15'){ echo "selected"; }?>>15</option>
                                                                <option value="16" <?php if($configs['watermark_small_thumb_font_size']=='16'){ echo "selected"; }?>>16</option>
                                                                <option value="17" <?php if($configs['watermark_small_thumb_font_size']=='17'){ echo "selected"; }?>>17</option>
                                                                <option value="18" <?php if($configs['watermark_small_thumb_font_size']=='18'){ echo "selected"; }?>>18</option>
                                                                <option value="19" <?php if($configs['watermark_small_thumb_font_size']=='19'){ echo "selected"; }?>>19</option>
                                                                <option value="20" <?php if($configs['watermark_small_thumb_font_size']=='20'){ echo "selected"; }?>>20</option>
                                                                <option value="21" <?php if($configs['watermark_small_thumb_font_size']=='21'){ echo "selected"; }?>>21</option>
                                                                <option value="22" <?php if($configs['watermark_small_thumb_font_size']=='22'){ echo "selected"; }?>>22</option>
                                                                <option value="23" <?php if($configs['watermark_small_thumb_font_size']=='23'){ echo "selected"; }?>>23</option>
                                                                <option value="24" <?php if($configs['watermark_small_thumb_font_size']=='24'){ echo "selected"; }?>>24</option>
                                                                <option value="25" <?php if($configs['watermark_small_thumb_font_size']=='25'){ echo "selected"; }?>>25</option>
                                                                <option value="26" <?php if($configs['watermark_small_thumb_font_size']=='26'){ echo "selected"; }?>>26</option>
                                                                <option value="27" <?php if($configs['watermark_small_thumb_font_size']=='27'){ echo "selected"; }?>>27</option>                                                                
                                                                <option value="28" <?php if($configs['watermark_small_thumb_font_size']=='28'){ echo "selected"; }?>>28</option>                                                                
                                                                <option value="29" <?php if($configs['watermark_small_thumb_font_size']=='29'){ echo "selected"; }?>>29</option>                                                                
                                                                <option value="30" <?php if($configs['watermark_small_thumb_font_size']=='30'){ echo "selected"; }?>>30</option>                                                                
                                                                <option value="31" <?php if($configs['watermark_small_thumb_font_size']=='31'){ echo "selected"; }?>>31</option>                                                                
                                                                <option value="32" <?php if($configs['watermark_small_thumb_font_size']=='32'){ echo "selected"; }?>>32</option>                                                                
                                                                <option value="33" <?php if($configs['watermark_small_thumb_font_size']=='33'){ echo "selected"; }?>>33</option>                                                                
                                                                <option value="34" <?php if($configs['watermark_small_thumb_font_size']=='34'){ echo "selected"; }?>>34</option>                                                                
                                                                <option value="35" <?php if($configs['watermark_small_thumb_font_size']=='35'){ echo "selected"; }?>>35</option>                                                                
                                                                <option value="36" <?php if($configs['watermark_small_thumb_font_size']=='36'){ echo "selected"; }?>>36</option>                                                                
                                                                <option value="37" <?php if($configs['watermark_small_thumb_font_size']=='37'){ echo "selected"; }?>>37</option>                                                                
                                                                <option value="38" <?php if($configs['watermark_small_thumb_font_size']=='38'){ echo "selected"; }?>>38</option>                                                                
                                                                <option value="39" <?php if($configs['watermark_small_thumb_font_size']=='39'){ echo "selected"; }?>>39</option>                                                                
                                                                <option value="40" <?php if($configs['watermark_small_thumb_font_size']=='40'){ echo "selected"; }?>>40</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px 0px 0px 5px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('small_thumb_watermark_font_color'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-paint-brush"></i>
                                                            </div>
                                                            <input type="color" name="small_thumb_watermark_font_color" placeholder="<?= lang('small_thumb_watermark_font_color'); ?>" class="form-control" value="<?php if($configs['watermark_small_thumb_font_color']!=""){ echo $configs['watermark_small_thumb_font_color']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    </div>    
                                                    <div class="watermark_type_image" <?php if($configs['watermark_type']=='text'){ echo " style='display:none;' "; } ?>>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <p><label for="watermark_small_thumb_image"><?= lang('upload_watermark_small_thumb_image'); ?></label></p>
                                                            <input type="file" id="watermark_small_thumb_image" name="watermark_small_thumb_image" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                        </div>
                                                    </div>    
                                                    <div class="col-md-6" style="padding: 0px 5px 0px 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('small_thumb_watermark_vertical_allignment'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-arrow-circle-down"></i>
                                                            </div>
                                                            <select class="form-control" name="small_thumb_watermark_vertical_allignment">
                                                                <option value="" disabled selected><?= lang('small_thumb_watermark_vertical_allignment'); ?></option>
                                                                <option value="top" <?php if($configs['watermark_small_thumb_vertical_align']=='top'){ echo "selected"; }?>><?= lang('top'); ?></option>
                                                                <option value="middle" <?php if($configs['watermark_small_thumb_vertical_align']=='middle'){ echo "selected"; }?>><?= lang('middle'); ?></option>                                                                
                                                                <option value="bottom" <?php if($configs['watermark_small_thumb_vertical_align']=='bottom'){ echo "selected"; }?>><?= lang('bottom'); ?></option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0px 0px 0px 5px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('small_thumb_watermark_horizontal_allignment'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-arrow-circle-up"></i>
                                                            </div>
                                                            <select class="form-control" name="small_thumb_watermark_horizontal_allignment">
                                                                <option value="" disabled selected><?= lang('small_thumb_watermark_horizontal_allignment'); ?></option>
                                                                <option value="left" <?php if($configs['watermark_small_thumb_horizontal_align']=='left'){ echo "selected"; }?>><?= lang('left'); ?></option>
                                                                <option value="center" <?php if($configs['watermark_small_thumb_horizontal_align']=='center'){ echo "selected"; }?>><?= lang('center'); ?></option>                                                                
                                                                <option value="right" <?php if($configs['watermark_small_thumb_horizontal_align']=='right'){ echo "selected"; }?>><?= lang('right'); ?></option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php                                                                            
                                                        }
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/watermark_settings/" class="btn btn-default"><?= lang('cancel'); ?></a>
                                                    </div>
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
                                            <div class="col-md-12 no_padding">
                                                <?php
                                                    if(isset($configs['watermark_small_thumb_image'])){
                                                        if($configs['watermark_small_thumb_image']!=""){
                                                ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <i class="fa fa-wordpress"></i> &nbsp;<?= lang('small_thumbnail_watermark_image'); ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <?php
                                                            $file_name = $configs['watermark_small_thumb_image'];                                                            
                                                        ?>
                                                        <img src="/public_html/upload/images/<?= $file_name; ?>" class="img-responsive"/>
                                                    </div>
                                                </div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-12 no_padding">
                                                <?php
                                                    if(isset($configs['watermark_large_thumb_image'])){
                                                        if($configs['watermark_large_thumb_image']!=""){
                                                ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <i class="fa fa-wordpress"></i> &nbsp;<?= lang('large_thumbnail_watermark_image'); ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <?php
                                                            $file_name = $configs['watermark_large_thumb_image'];                                                              
                                                        ?>
                                                        <img src="/public_html/upload/images/<?= $file_name; ?>" class="img-responsive"/>
                                                    </div>
                                                </div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </section>                           
                    </section>
                    <script>
                        $(document).ready(function(e){
                            $(".watermark_settings_form").submit(function(e){
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.watermark_settings_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_watermark_settings_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/watermark_settings/";
                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();                                        
                                        } else {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                        }
                                        $(".submit_btn").html("<?= lang('save'); ?>");
                                        $(".submit_btn").prop("disabled",false);
                                    },
                                    error:function(err){
                                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){
                                            console.log();
                                            $(".submit_btn").html("<?= lang('save'); ?>");
                                            $(".submit_btn").prop("disabled",false);
                                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                    }
                                });
                            });
                        });
                        $(function () {
                            $('#edit').froalaEditor({
                                placeholderText: "<?= lang('write_about_us'); ?>",

                                // Set the file upload URL.
                                type: "post",
                                imageUploadURL: "<?= site_url() ?>api/files/upload_image",
                                imageUploadParams: {
                                    id: 'my_editor'
                                },
                                // Set the file upload URL.
                                type: "post",
                                fileUploadURL:  "<?= site_url() ?>api/files/upload_file",
                                fileUploadParams: {
                                    id: 'my_editor'
                                },
                                // Set the video upload URL.
                                type: "post",
                                videoUploadURL: "<?= site_url() ?>api/files/upload_video",
                                videoUploadParams: {
                                    id: 'my_editor'
                                },
                            });
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_about_us'); ?>");
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                e.preventDefault();
                            });
                        });
                        $(".watermark_type").on('change',function(e){
                            type = $(".watermark_type").val();
                            if(type=='text'){
                                $(".watermark_type_text").css('display','block');
                            }
                            else{
                                $(".watermark_type_text").css('display','none');
                            }
                            if(type=='image'){
                                $(".watermark_type_image").css('display','block');
                            }
                            else{
                                $(".watermark_type_image").css('display','none');
                            }
                        })
                   </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>