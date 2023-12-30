<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
        <style>
            textarea, select, .tg-select select, .form-control, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{ text-transform: none;}
            body{
                font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
            }
        </style>
    </head>
    <body class="">
        <?php
            $this->load->view('block.head.php');
        ?>
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp" style="padding-top: 100px;background: url(/public_html/images/website-backgrounds.jpg);">    
            <div class="container aside-xxl">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4" style="padding: 0px 15px;">
                        <section class="panel panel-default bg-white m-t-lg">
                            <header class="panel-heading">
                                <center><strong><?= lang('registration'); ?></strong></center>
                            </header>
                            <form class="panel-body wrapper-lg register_form" method="post">
                                <div class="form-group">
                                    <label class="control-label"><?= lang('full_name'); ?></label>
                                    <input type="text" name="full_name" class="form-control input-lg full_name" value="" autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= lang('email'); ?></label>
                                    <input type="email" name="email" class="form-control input-lg" value="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= lang('password'); ?></label>
                                    <input type="password" name="password" id="inputPassword" class="form-control input-lg" value="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= lang('mobile_number'); ?></label>
                                    <input type="number" name="mobile_number" id="inputPassword" class="form-control input-lg" value="">
                                </div>
                                <button type="submit" class="btn btn-default sub_btn"><?= lang('create_an_account'); ?></button>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>login"><?= lang('login'); ?></a>
                                <a href="<?= site_url(); ?>login/forgot_password" class="pull-right"><?= lang('forgot_password'); ?></a>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>" class="btn btn-default btn-block"><?= sprintf(lang('go_back_to_main_site'),SITE_TITLE); ?></a>
                            </form>
                        </section>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                        
            </div>
        </section>
        <script>
            $(document).ready(function(e){
                $(".full_name").focus();
            });
             $(".register_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data: $(".register_form").serialize(),
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/users/save_user_details",
                    success: function (data) {
                        if (data.status) {
                            window.location = "<?= site_url().USER_PROFILE_DIR_NAME ?>subscription";
                        } 
                        else {
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                    
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                        $(".sub_btn").html("<?= lang('create_an_account'); ?>");
                        $(".sub_btn").prop("disabled",false);
                    },
                    error:function(err){
                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_inetrnal_error'); ?>" , function(){
                            console.log();
                            $(".sub_btn").html("<?= lang('create_an_account'); ?>");
                            $(".sub_btn").prop("disabled",false);
                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                    }
                });
            });
        </script>
        <?php
            $this->load->view('block.foot.php');
        ?>
    </body>
</html>