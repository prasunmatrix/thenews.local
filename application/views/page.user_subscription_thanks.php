<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
        <title><?= $page_title; ?></title>
        <style>
            .nav>li>a {
                position: relative;
                display: block;
                padding: 7px 7px;
            }
        </style>
    </head>
    <body class="">
        <?php
            $this->load->view('block.head.php');
        ?>
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp" style="padding-top: 40px;">    
            <div class="container aside-xxl">
                <div class="row">
                    <div class="col-md-12" style="padding: 60px 0px;">
                        <ul class="nav nav-tabs" style="padding-left: 15px;">
                            <li class="active"><a data-toggle="tab" href="#subscribe_a_plan"><?= lang('thanks_for_subscribe'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="subscribe_a_plan" class="tab-pane fade in active" style="padding-top: 20px;">
                                <div class="col-md-12">
                                    <div class="col-xs-12">
                                        <center><img src="/public_html/images/checkmarksuccess.gif" style="margin-top:-20px;" class="img-responsive"/></center>
                                        <p class="text-center" style="margin-bottom: 5px;"><?= lang('your_account_successfully_subscribed_for_pb_24_news'); ?></p>
                                        <p class="text-center" style="margin-bottom: 5px;"><?= lang('now_you_can_enjoy_premium_news_from_the_pb24'); ?></p>
                                        <p class="text-center" style="margin-bottom: 25px;"><?= sprintf(lang('you_plan_valid_till'),"<span style='font-family:auto;'>" . date('d-m-Y', strtotime($end_date))."</span>"); ?></p>
                                        <p class="text-center" style="margin-bottom: 25px;"><?= lang('this_page_will_be_redirect_to_home_page_in_5_seconds'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function(){
                setTimeout(function(){
                    window.location.href = "<?= site_url(); ?>";
                },5000);
            });
        </script>
        <?php
            $this->load->view('block.foot.php');
        ?>
    </body>
</html>