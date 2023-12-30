<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
        <title><?= lang('your_email_verified_successfully'); ?></title>
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
                        <div class="tab-content">
                            <div id="subscribe_a_plan" class="tab-pane fade in active" style="padding-top: 20px;">
                                <div class="col-md-12">
                                    <div class="col-xs-12">
                                        <center><img src="/public_html/images/checkmarksuccess.gif" style="margin-top:-20px;" class="img-responsive"/></center>
                                        <p class="text-center" style="margin-bottom: 5px;"><?= lang('your_email_verified_successfully'); ?></p>
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
                    window.location.href = "<?= site_url() ?>";
                },5000);
            });
        </script>
        <?php
            $this->load->view('block.foot.php');
        ?>
    </body>
</html>