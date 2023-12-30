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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/website_logos"><i class="fa fa-image"></i> &nbsp;<?= lang('website_logos'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_website_logos'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="website_logos_form">
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_website_logos'); ?></div>
                                                <div class="panel-body">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='favicon_icon'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <p><?= lang('favicon_icon'); ?></p>
                                                        <input type="file" name="favicon_icon" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='logo_white'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <p><?= lang('white_logo'); ?></p>
                                                        <input type="file" name="white_logo" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                    </div>
                                                    <?php                
                                                                }
                                                                if($config['config_name']=='logo_black'){
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <p><?= lang('black_logo'); ?></p>
                                                        <input type="file" name="black_logo" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
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
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/website_logos/" class="btn btn-default"><?= lang('cancel'); ?></a>
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
                            $(".website_logos_form").submit(function(e){
                                form = $('.website_logos_form')[0];
                                data = new FormData(form);
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_website_logos_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/website_logos/";
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