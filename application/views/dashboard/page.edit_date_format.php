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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/date_format"><i class="fa fa-calendar"></i> &nbsp;<?= lang('date_format'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_date_time_settings'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="date_format_form">
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_date_time_settings'); ?></div>
                                                <div class="panel-body">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='date_format'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <select name="date_format" class="form-control">
                                                                <option value="" disabled selected><?= lang('date_format'); ?></option>
                                                                <option value="M d, Y" <?php if($config['config_value']=="M d, Y"){ echo "selected"; } ?>><?= date('M d, Y',now()); ?></option>
                                                                <option value="d-m-Y" <?php if($config['config_value']=="d-m-Y"){ echo "selected"; } ?>><?= date('d-m-Y',now()); ?></option>
                                                                <option value="D j/n/Y" <?php if($config['config_value']=="D j/n/Y"){ echo "selected"; } ?>><?= date('D j/n/Y',now()); ?></option>
                                                                <option value="jS F Y" <?php if($config['config_value']=="jS F Y"){ echo "selected"; } ?>><?= date('jS F Y',now()); ?></option>
                                                                <option value="d M y" <?php if($config['config_value']=="d M y"){ echo "selected"; } ?>><?= date('d M y',now()); ?></option>
                                                                <option value="l jS F" <?php if($config['config_value']=="l jS F"){ echo "selected"; } ?>><?= date('l jS F',now()); ?></option>
                                                                <option value="Y-m-d" <?php if($config['config_value']=="Y-m-d"){ echo "selected"; } ?>><?= date('Y-m-d',now()); ?></option>
                                                                <option value="d/m/Y" <?php if($config['config_value']=="d/m/Y"){ echo "selected"; } ?>><?= date('d/m/Y',now()); ?></option>
                                                                <option value="l, d-M-Y" <?php if($config['config_value']=="l, d-M-Y"){ echo "selected"; } ?>><?= date('l, d-M-Y',now()); ?></option>
                                                                <option value="D, d M y" <?php if($config['config_value']=="D, d M y"){ echo "selected"; } ?>><?= date('D, d M y',now()); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='time_format'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-clock-o"></i>
                                                            </div>
                                                            <select name="time_format" class="form-control">
                                                                <option value="" disabled selected><?= lang('time_format'); ?></option>
                                                                <option value="H:i:s" <?php if($config['config_value']=="H:i:s"){ echo "selected"; } ?>><?= date('H:i:s',now()); ?></option>
                                                                <option value="g:i a" <?php if($config['config_value']=="g:i a"){ echo "selected"; } ?>><?= date('g:i a',now()); ?></option>
                                                                <option value="h:i A" <?php if($config['config_value']=="h:i A"){ echo "selected"; } ?>><?= date('h:i A',now()); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='timezone'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-globe"></i>
                                                            </div>
                                                            <?php
                                                            	$current_timezone = date_default_timezone_get();

                                                                $timezones = array();
                                                                $timestamp = time();
                                                                foreach(timezone_identifiers_list() as $key => $zone)
                                                                {
                                                                    date_default_timezone_set($zone);
                                                                    $timezones[$key]['zone'] = $zone;
                                                                    $timezones[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
                                                                }
                                                                
                                                                // reset the timezone
                                                                date_default_timezone_set($current_timezone);
                                                            ?>
                                                            <select name="timezone" id="timezone" class="form-control select2">
                                                                <?php foreach($timezones as $t) { ?>
                                                                    <option value="<?= $t['zone']; ?>" <?php if($config['config_value']==$t['zone']){ echo "selected"; } ?>>
                                                                        <?= $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                            }
                                                        }
                                                        else{
                                                            echo lang('no_data_found');
                                                        }
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/date_format/" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                                                        <?= lang('given_date_and_time_format_will_be_applicable_in_the_entire_website'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </section>                           
                    </section>
                    <script>
                        $(document).ready(function(e){
                        
                            $(".select2").select2({
                                placeholder: "<?= lang('select_timezone'); ?>",
                                allowClear: true
                            });
                        
                            $(".date_format_form").submit(function(e){
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                $.ajax({
                                    data: $(".date_format_form").serialize(),
                                    type: "post",
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_date_format_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/date_format/";
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
                   </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>