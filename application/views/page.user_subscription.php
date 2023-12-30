<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    if($this->session->userdata('normal_user')){
        setcookie('loggedin_user_id', $this->session->userdata('normal_user'), time() + (86400 * 30), "/"); // 86400 = 1 day
    }
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
                            <li class="active"><a data-toggle="tab" href="#subscribe_a_plan"><?= lang('choose_a_plan'); ?></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="subscribe_a_plan" class="tab-pane fade in active" style="padding-top: 20px;">
                                <div class="col-md-12">
                                    <?php
                                        if($profile_details[0]['subscription_end_date']>date('Y-m-d',time())){
                                            echo "Already subscribed";
                                        }
                                        else{
                                    ?>
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="tg-pkgplans">
                                        <?php
                                            if(!empty($subscriptions)){
                                                foreach($subscriptions as $plan){
                                                ?>
                                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                        <div class="tg-pkgplan">
                                                            <div class="tg-planhead">
                                                                <h3><?= $plan['sub_title']; ?></h3>
                                                                <h4></h4>
                                                                <h5><sup><i class="fa fa-rupee-sign"></i></sup> <?= $plan['sub_price']; ?> <sub></sub></h5>
                                                            </div>
                                                            <div class="tg-planbody">
                                                                <ul>
                                                                    <li>Full website Support</li>
                                                                    <li>Full application Support</li>
                                                                    <li><span class="tg-empty"></span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tg-planfoot">
                                                                <center>
                                                                    <?php
                                                                        if(isset($plan['sub_btn'])){
                                                                            echo $plan['sub_btn'];
                                                                        }
                                                                    ?>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                <?php
                                                }
                                            }
                                        ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
        
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            $this->load->view('block.foot.php');
        ?>
    </body>
</html>