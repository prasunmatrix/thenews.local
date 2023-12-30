<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
?>
        <title><?= $page_title; ?></title>
        <style>
            .nav>li>a {
                position: relative;
                display: block;
                padding: 7px 10px;
            }
        </style>
        <script>
            setCookie('loggedin_user_id', "<?= $this->session->userdata('normal_user'); ?>", 30);
        </script>
    </head>
    <body class="">
        <?php
            $this->load->view('block.head.php');
        ?>
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp" style="padding-top: 40px;">    
            <div class="container aside-xxl">
                <div class="row">
                    <div class="col-md-12" style="padding: 50px 0px;">
                        
                        <ul class="nav nav-tabs" style="padding-left: 15px;">
                            <li class="active"><a data-toggle="tab" href="#account_details"><?= lang('account_details'); ?></a></li>
                            <li><a data-toggle="tab" href="#favorite"><?= lang('favorite'); ?></a></li>
                            <li><a data-toggle="tab" href="#change_password"><?= lang('change_password'); ?></a></li>
                        </ul>

                        <div class="tab-content">
                            
                            <div id="account_details" class="tab-pane fade in active" style="padding-top: 20px;">
                                <div class="col-md-12">
                                    <p><?= lang('name'); ?> &emsp; <strong><?php if(isset($profile_details[0]['first_name'])){ echo $profile_details[0]['first_name']; } else { echo lang('not_available'); } ?></strong></p>
                                </div>
                                <div class="col-md-12">
                                    <p><?= lang('email'); ?> &emsp; <strong><?php if(isset($profile_details[0]['email'])){ echo "<span style='font-family:auto;'>" . $profile_details[0]['email'] . "</span>"; } else { echo lang('not_available'); } ?></strong></p>
                                </div>
                                <?php
                                    $sub_plan = lang('not_available');
                                    if(!empty($subscriptions)){
                                        foreach($subscriptions as $plan){
                                            if($plan['sub_id']==$profile_details[0]['subscribed_plan_id']){
                                                $sub_plan = $plan['sub_title'];
                                            }
                                        }
                                    }
                                ?>
                                <div class="col-md-12">
                                    <p><?= lang('subscribed_plan_id'); ?> &emsp; <strong><?php if(isset($sub_plan)){ echo "<span style='font-family:auto;'>" . $sub_plan . "</span>"; } else { echo lang('not_available') . " &emsp;<a href='" . site_url() . "profile/subscription'>" . lang('subscribe_a_plan') . "</a>"; } ?></strong></p>
                                </div>
                                <div class="col-md-12">
                                    <p><?= lang('subscription_end_date'); ?> &emsp; <strong><?php if(isset($profile_details[0]['subscription_end_date'])&& $profile_details[0]['subscription_end_date']!="0" && $profile_details[0]['subscription_end_date']!="0000-00-00"){ if($profile_details[0]['subscription_end_date']<date('Y-m-d')){ echo sprintf(lang("it_seems_your_plan_has_been_expired_on_x"),"<span style='font-family:auto;'>" . date($configs['date_format'],strtotime($profile_details[0]['subscription_end_date'])) . "</span>") . " " . lang('click_here_to_subscribe'); } else{ echo "<span style='font-family:auto;'>" . date($configs['date_format'],strtotime($profile_details[0]['subscription_end_date'])) . "</span>"; } } else { echo lang('click_here_to_subscribe'); } ?></strong></p>
                                </div>
                                <div class="col-md-12">
                                    <p><?= lang('phone'); ?> &emsp; <strong><?php if(isset($profile_details[0]['phone'])){ echo "<span style='font-family:auto;'>" . $profile_details[0]['phone'] . "</span>"; } else { echo lang('not_available'); } ?></strong></p>
                                </div>
                            </div>
                            <div id="favorite" class="tab-pane fade" style="padding-top: 20px;">
                                <div class="col-md-12">
                                    <?php
                                        if(empty($bookmarks_news)&&empty($bookmarks_videos)){
                                    ?>
                                    <p class="alert alert-warning text-center"><?= lang('no_favorite_item_found'); ?></p>
                                    <?php
                                        }
                                        else{
                                            $count = 0;
                                            if(!empty($bookmarks_news)){
                                                foreach($bookmarks_news as $news){
                                                    $count++;
                                                    echo "<a href='" . site_url() . "news/view/" . $news->rand_id . "'>". $count .". ". $news->news_title . "</a><br>";
                                                }
                                            }
                                            if(!empty($bookmarks_videos)){
                                                foreach($bookmarks_videos as $news){
                                                    $count++;
                                                    echo "<a href='" . site_url() . "videos/view/" . $news->rand_id . "'>". $count .". " . $news->video_title . "</a><br>";
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div id="change_password" class="tab-pane fade" style="padding-top: 20px;">
                                <div class="col-md-6">
                                    <form method="" class="change_password_form">
                                        <div class="form-group">
                                            <label class="control-label"><?= lang('current_password'); ?></label>
                                            <input type="password" name="old_password" class="form-control input-lg" value="">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= lang('new_password'); ?></label>
                                            <input type="password" name="new_password" class="form-control input-lg" value="">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= lang('confirm_new_password'); ?></label>
                                            <input type="password" name="c_new_password" class="form-control input-lg" value="">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-default sub_btn btn-sm" type="submit"><?= lang('change_password'); ?></button>
                                        </div>
                                    </form>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding: 50px 0px;">
                        <div class="col-xs-10">&emsp;</div>
                        <div class="col-xs-2">
                            <a href="<?= site_url(); ?>profile/logout" xonclick="logout()" class="btn btn-danger btn-sm pull-right mb-27"><?= lang('logout'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            $this->load->view('block.foot.php');
        ?>
        
        <script>
            $(".change_password_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data:$(".change_password_form").serialize(),
                    type:"post",
                    dataType: 'json',
                    url:"<?= site_url() ?>api/users/change_password",
                    success: function(data){
                        if(data.status){
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                location.reload();
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();    
                        }                         
                        else{
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                $(".sub_btn").prop('disabled',false);
                                $(".sub_btn").html("<?= lang('change_password'); ?>");
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();    
                        }
                    },
                    error: function(err){
                        $(".sub_btn").prop('disabled',false);
                        $(".sub_btn").html("<?= lang('change_password'); ?>");
                    }
                });
            });
            
                    
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '337142391335995',
              cookie     : true,
              xfbml      : true,
              version    : 'v2.7'
            });
              
            FB.AppEvents.logPageView();   
              
          };
        
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
           
            function logout(){
                window.location.href = "<?= site_url().USER_PROFILE_DIR_NAME ?>logout";
                /* FB.getLoginStatus(function(response) {
                    FB.logout(function(response){
                      console.log("Logged Out!");
                      window.location.href = "<?= site_url().USER_PROFILE_DIR_NAME ?>logout";
                    });
                  });*/
            }
        </script>
    </body>
</html>