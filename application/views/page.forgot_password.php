<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
        
        <style>
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
                    <div class="col-md-4" style="padding: 80px 0px;">
                        <section class="panel panel-default bg-white m-t-lg">
                            <header class="panel-heading">
                                <center><strong><?= lang('forgot_password'); ?></strong></center>
                            </header>
                            <form class="panel-body wrapper-lg forgot_password_form" method="post">
                                <div class="form-group">
                                    <label class="control-label"><?= lang('email'); ?></label>
                                    <input type="text" name="email" class="form-control" value="" autofocus style="text-transform:lowercase;">
                                </div>
                                <button type="submit" class="btn btn-default sub_btn"><?= lang('submit'); ?></button>
                                <div class="response_section" style="padding-top: 15px;"></div>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>login/register"><?= lang('create_an_account'); ?></a>
                                <a href="<?= site_url(); ?>login" class="pull-right"><?= lang('login'); ?></a>
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
             $(".forgot_password_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data: $(".forgot_password_form").serialize(),
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/users/forgot_password",
                    success: function (data) {
                        if (data.status) {
                            $(".response_section").html("<p class='alert alert-success'>" + data.message + "</p>");
                            setTimeout(function(){
                               window.location = "<?= site_url() ?>login";
                            }, 5000);
                        } 
                        else {
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                    
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                        $(".sub_btn").html("<?= lang('login'); ?>");
                        $(".sub_btn").prop("disabled",false);
                    },
                    error:function(err){
                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_inetrnal_error'); ?>" , function(){
                            console.log();
                            $(".sub_btn").html("<?= lang('login'); ?>");
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