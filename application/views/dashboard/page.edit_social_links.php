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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/social_links"><i class="fa fa-facebook"></i> &nbsp;<?= lang('social_links'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_social_links'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="social_media_links_form">                                        
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-file-text-o"></i> &nbsp;<?= lang('edit_social_links'); ?></div>
                                                <div class="panel-body">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='fb_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('facebook'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-facebook-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="facebook" placeholder="<?= lang('facebook'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='insta_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('instagram'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-instagram"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="instagram" placeholder="<?= lang('instagram'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='linkdin_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('linkedin'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-linkedin-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="linkedin" placeholder="<?= lang('linkedin'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='youtube_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('youtube'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-youtube-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="youtube" placeholder="<?= lang('youtube'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='twitter_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('twitter'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-twitter-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="twitter" placeholder="<?= lang('twitter'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='whatsapp_number'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('whatsapp'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-comments-o"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="whatsapp" placeholder="<?= lang('whatsapp'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='pinterest_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('pinterest'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-pinterest-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="pinterest" placeholder="<?= lang('pinterest'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='tumblr_url'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group" data-toggle="tooltip" title="<?= lang('tumblr'); ?>" data-placement="top">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-tumblr-square"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="tumblr" placeholder="<?= lang('tumblr'); ?>" value="<?php if($config['config_value']!=""){ echo $config['config_value']; } ?>"/>
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
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/social_links/" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                            $(".social_media_links_form").submit(function(e){
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                $.ajax({
                                    data: $(".social_media_links_form").serialize(),
                                    type: "post",
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_social_media_links_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/social_links/";
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