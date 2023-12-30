<?php
    //$this->load->view('page.stat.php');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <link rel="stylesheet" href="/public_html/theme/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="/public_html/theme/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/public_html/theme/css/font.css" type="text/css" />
        <link rel="stylesheet" href="/public_html/theme/css/alertify.min.css" type="text/css" />
        <link rel="stylesheet" href="/public_html/theme/css/app.css" type="text/css" />
        <script src="/public_html/theme/js/jquery.min.js"></script>
        <script src="/public_html/theme/js/alertify.min.js"></script>
        
    </head>
    <body class="">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
            <div class="container aside-xxl">
                <a class="navbar-brand block" href="<?= site_url(); ?>"><?= SITE_TITLE ?></a>
                <section class="panel panel-default bg-white m-t-lg">
                    <header class="panel-heading text-center">
                        <strong><?= lang('login'); ?></strong>
                    </header>
                    <form class="panel-body wrapper-lg login_form" method="post">
                        <div class="form-group">
                            <label class="control-label"><?= lang('email'); ?></label>
                            <input type="text" name="email" class="form-control input-lg" value="" autofocus>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= lang('password'); ?></label>
                            <input type="password" name="password" id="inputPassword" class="form-control input-lg" value="">
                        </div>
                        <button type="submit" class="btn btn-primary sub_btn"><?= lang('login'); ?></button>
                        <div class="line line-dashed"></div>
                        <a href="<?= site_url(); ?>" class="btn btn-default btn-block"><?= sprintf(lang('go_back_to_main_site'),SITE_TITLE); ?></a>
                    </form>
                </section>
            </div>
        </section>
        <!-- footer -->
        <footer id="footer">
            <div class="text-center padder">
                <p>
                    <small>&copy; <?= date('Y'); ?> <?= SITE_TITLE ?> | <?= lang('all_rights_are_reserved'); ?></small>
                </p>
            </div>
        </footer>
        <script>
             $(".login_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data: $(".login_form").serialize(),
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/users/admin_login",
                    success: function (data) {
                        if (data.status) {
                            window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>";
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
        <!-- / footer -->
        <script src="/public_html/theme/js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/public_html/theme/js/bootstrap.js"></script>
        <!-- App -->
        <script src="/public_html/theme/js/app.js"></script> 
        <script src="/public_html/theme/js/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="/public_html/theme/js/app.plugin.js"></script>
    </body>
</html>