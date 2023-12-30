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
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp" style="padding-top: 40px;">    
            <div class="container aside-xxl">
                <div class="row">
                    <div class="col-xs-12">
                        <center><img src="/public_html/images/checkmarksuccess.gif" style="margin-top:-20px;" class="img-responsive"/></center>
                        <p class="text-center" style="margin-bottom: 5px;"><?= lang('your_account_password_has_been_changed_successfully'); ?></p>
                        <p class="text-center" style="margin-bottom: 5px;"><?= lang('please_open_pratibadi_kalam_app_for_login'); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>