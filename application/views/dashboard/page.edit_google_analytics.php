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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_analytics"><i class="fa fa-google"></i> &nbsp;<?= lang('google_analytics'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_google_analytics'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="google_analytics_form">
                                        <div class="col-md-4">
                                            <div class="col-md-12" style="padding: 0px;">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><i class="fa fa-google"></i> &nbsp;<?= lang('edit_google_analytics'); ?></div>
                                                    <div class="panel-body">
                                                        <?php
                                                            $analytics_code = "xxxxxxxx-x";
                                                            if(!empty($general_config)){
                                                                foreach($general_config as $config){
                                                                    if($config['config_name']=='analytics_code'){
                                                                        if($config['config_value']!=""){
                                                                            $analytics_code = $config['config_value'];
                                                                        }
                                                        ?>
                                                        <div class="">
                                                            <p><?= lang('tracking_id'); ?></p>
                                                            <input type="text" maxlength="16" name="tracking_id" value="<?= $config['config_value']; ?>" class="form-control"/>
                                                        </div>
                                                        <?php                
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                echo lang('no_data_found');
                                                            }
                                                        ?>
                                                        <div class="col-md-12" style="padding: 0px;margin-top: 20px;margin-bottom: 10px;">
                                                            <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                            <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_analytics/" class="btn btn-default"><?= lang('cancel'); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-info"></i> &nbsp;<?= lang('instructions'); ?></div>
                                                <div class="panel-body">
                                                    <strong><p><?= lang('general_instructions'); ?></p></strong>
                                                    <ul>
                                                        <li><?= lang('you_google_analytics_code_look_like_this'); ?></li>
                                                        <li><?= lang('you_can_not_modify_the_entire_analytics_code_due_to_security_issues'); ?></li>
                                                        <li><?= lang('for_enable_your_google_analytics_report_you_can_edit_tracking_id_in_this_code'); ?></li>
                                                    </ul>
                                                    <strong><p><?= lang('google_analytics_code'); ?></p></strong>
                                                    &lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;<br>
                                                    &lt;script async src="https://www.googletagmanager.com/gtag/js?id=<span style="color:red;"><?= $analytics_code; ?></span>"&gt;&lt;/script&gt;<br>
                                                    &lt;script&gt;<br>
                                                        &emsp;window.dataLayer = window.dataLayer || [];<br>
                                                        &emsp;function gtag(){dataLayer.push(arguments);}<br>
                                                        &emsp;gtag('js', new Date());<br>
                                                        <br>
                                                        &emsp;gtag('config', '<span style="color:red;"><?= $analytics_code; ?></span>');<br>
                                                    &lt;/script&gt;<br>
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
                            $(".google_analytics_form").submit(function(e){                                
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                $.ajax({
                                    data: $(".google_analytics_form").serialize(),
                                    type: "post",
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_google_analytics_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/google_analytics/";
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
                        
                   </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>