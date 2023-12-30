<section class="vbox">
            <?php
                if ($this->session->userdata('ds_user')) {
                    $user_details = $this->users_model->get_where('users',array('user_id'=>$this->session->userdata('ds_user')));
                    $general_configs = $this->users_model->get_where('general_config',array('deleted'=>'0'));
                    $languages = $this->users_model->get_where('languages',array('deleted'=>'0','visibility'=>'1'));
                }
            ?>
    
            <header class="bg-dark dk header navbar navbar-fixed-top-xs">
                <div class="navbar-header aside-md">
                    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                        <i class="fa fa-bars"></i>
                    </a>
                    <a href="<?= site_url() ?>" class="navbar-brand text-center" data-toggle="fullscreen"><?= SITE_TITLE ?></a>
                    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                        <i class="fa fa-cog"></i>
                    </a>
                </div>                
                <ul class="nav navbar-nav m-n hidden-xs">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="pull-left">
                                <i class="fa fa-language"></i>
                            </span>
                            &emsp;<?= lang('languages'); ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight">
                            <span class="arrow top"></span>
                            <?php
                                foreach($languages as $language){
                            ?>
                            <li>
                                <a href="<?= base_url()?><?= $language['url_prefix']; ?>/<?= str_replace(site_url(),'',base_url(uri_string())); ?>"><?= $language['language']; ?></a>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
                    <li class="hidden-xs">
                        <a href="/" target='_BLANK' data-toggle="tooltip" data-placement="bottom" title="<?= lang('visit_website'); ?>"><i class="fa fa-fw fa-globe"></i></a>
                    </li>
<!--                    <li class="hidden-xs">
                        <a href="/public_html/dashboard/#" class="dropdown-toggle dk" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="badge badge-sm up bg-danger m-l-n-sm count">2</span>
                        </a>
                        <section class="dropdown-menu aside-xl">
                            <section class="panel bg-white">
                                <header class="panel-heading b-light bg-light">
                                    <strong><?= sprintf(lang('you_have_x_notifications'),'2'); ?></strong>
                                </header>
                                <div class="list-group list-group-alt animated fadeInRight">
                                    <a href="" class="media list-group-item">
                                        <span class="pull-left thumb-sm">
                                            <img src="/public_html/dashboard/images/avatar.jpg" alt="John said" class="img-circle">
                                        </span>
                                        <span class="media-body block m-b-none">
                                            Use awesome animate.css<br>
                                            <small class="text-muted">10 minutes ago</small>
                                        </span>
                                    </a>
                                    <a href="" class="media list-group-item">
                                        <span class="media-body block m-b-none">
                                            1.0 initial released<br>
                                            <small class="text-muted">1 hour ago</small>
                                        </span>
                                    </a>
                                </div>
                                <footer class="panel-footer text-sm">
                                    <a href="" class="pull-right"><i class="fa fa-cog"></i></a>
                                    <a href="" data-toggle="class:show animated fadeInRight"><?= lang('see_all_the_notifications'); ?></a>
                                </footer>
                            </section>
                        </section>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a href="/public_html/dashboard/#" class="dropdown-toggle dker" data-toggle="dropdown"><i class="fa fa-fw fa-search"></i></a>
                        <section class="dropdown-menu aside-xl animated fadeInUp">
                            <section class="panel bg-white">
                                <form role="search">
                                    <div class="form-group wrapper m-b-none">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-info btn-icon"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </section>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a href="#" onclick="start_intro()" data-toggle="tooltip" data-placement="bottom" title="<?= lang('take_a_tour'); ?>"><i class="fa fa-fw fa-question-circle-o"></i></a>
                    </li>-->
                    <li class="dropdown dropdown-user">
                        <a href="/public_html/dashboard/#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                                $avatar = "";
                                if(isset($user_details[0]['avatar'])){
                                    if(file_exists("./public_html/upload/user_avatars/".$user_details[0]['avatar'])){
                                        $avatar = "/public_html/upload/user_avatars/".$user_details[0]['avatar'];
                                    }
                                    else{
                                        $avatar = "/public_html/upload/user_avatars/user.png";
                                    }
                                }
                                else{
                                    $avatar = "/public_html/upload/user_avatars/user.png";
                                }
                                    
                            ?>
                            <span class="thumb-sm avatar pull-left">
                                <img src="<?= $avatar; ?>">
                            </span>
                            <?= $user_details[0]['first_name']?$user_details[0]['first_name']:""; ?> <?= $user_details[0]['last_name']?$user_details[0]['last_name']:""; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight">
                            <span class="arrow top"></span>
                            <li>
                                <a href="<?= site_url() ?>admin_login/logout"><?= lang('logout'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>      
            </header>
            <section>
                <section class="hbox stretch">
                    <!-- .aside -->
                    <aside class="bg-dark lter aside-md hidden-print hidden-xs" id="nav">          
                        <section class="vbox">
                            <section class="w-f scrollable">
                                <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                                    <!-- nav -->
                                    <nav class="nav-primary hidden-xs">
                                        <ul class="nav">
                                            <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)==""||$this->uri->segment(3)=="home")){ echo "class='active'"; } ?>>
                                                <a href="<?= site_url().DASHBOARD_DIR_NAME ?>">
                                                    <i class="fa fa-dashboard icon">
                                                        <b class="bg-danger dker"></b>
                                                    </i>
                                                    <span><?= lang('dashboard'); ?></span>
                                                </a>
                                            </li>
                                            <?php
                                                if($this->permissions_model->check('news','index') || $this->permissions_model->check('news_types','index') || $this->permissions_model->check('exclusive_news','index') || $this->permissions_model->check('live_news','index') || $this->permissions_model->check('epaper','index') || $this->permissions_model->check('videos','index')){
                                            ?>
                                            <li  <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="news"||$this->uri->segment(3)=="news_types"||$this->uri->segment(3)=="exclusive_news"||$this->uri->segment(3)=="live_news"||$this->uri->segment(3)=="epaper"||$this->uri->segment(3)=="videos")){ echo "class='active'"; } ?> class="events_menu">
                                                <a href=""  >
                                                    <i class="fa fa-newspaper-o">
                                                        <b class="bg-info"></b>
                                                    </i>
                                                    <span class="pull-right">
                                                        <i class="fa fa-angle-down text"></i>
                                                        <i class="fa fa-angle-up text-active"></i>
                                                    </span>
                                                    <span><?= lang('news'); ?></span>
                                                </a>
                                                <ul class="nav lt">
                                                    <?php
                                                        if($this->permissions_model->check('news','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="news")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>news">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('news'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('news_types','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="news_types")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>news_types">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('news_types'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('news','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="exclusive_news")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>exclusive_news">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('exclusive_news'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('news','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="live_news")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>live_news">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('live_news'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('epaper','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="epaper")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>epaper">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('epaper'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('videos','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="videos")){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>videos">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('videos'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                                }
                                                if($this->permissions_model->check('about_us','index') || $this->permissions_model->check('privacy_policy','index') || $this->permissions_model->check('terms_and_conditions','index') || $this->permissions_model->check('topics','index')){
                                            ?>
                                            <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"){ echo "class='active'"; } ?> class="settings_menu">
                                                <a href=""  >
                                                    <i class="fa fa-cogs icon">
                                                        <b class="bg-danger"></b>
                                                    </i>
                                                    <span class="pull-right">
                                                        <i class="fa fa-angle-down text"></i>
                                                        <i class="fa fa-angle-up text-active"></i>
                                                    </span>
                                                    <span><?= lang('settings'); ?></span>
                                                </a>
                                                <ul class="nav lt">
                                                    <?php
                                                        if($this->permissions_model->check('about_us','index')){
                                                    ?>
                                                    <!--<li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"&&$this->uri->segment(4)=="about_us"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/about_us">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('about_us'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('privacy_policy','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"&&$this->uri->segment(4)=="privacy_policy"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/privacy_policy">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('privacy_policy'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('terms_and_conditions','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"&&$this->uri->segment(4)=="terms_and_conditions"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/terms_and_conditions">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('terms_and_conditions'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('topics','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"&&$this->uri->segment(4)=="topics"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/topics">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('topics'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('menu_items','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="settings"&&$this->uri->segment(4)=="menu_items"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>settings/menu_items">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('menu_items'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                            <?php
                                                if($this->permissions_model->check('users','index') || $this->permissions_model->check('permissions','index') || $this->permissions_model->check('system_logs','index')){
                                            ?>
                                            <li <?php if($this->uri->segment(2)=="dashboard"&&($this->uri->segment(3)=="users"||$this->uri->segment(3)=="permissions"||$this->uri->segment(3)=="system_logs"||$this->uri->segment(3)=="general_settings"||$this->uri->segment(3)=="subscribers"||$this->uri->segment(3)=="contact_inquries"||$this->uri->segment(3)=="notifications"||$this->uri->segment(3)=="emails"||$this->uri->segment(3)=="email_settings"||$this->uri->segment(3)=="languages"||$this->uri->segment(3)=="visitors"||$this->uri->segment(3)=="migrate"||$this->uri->segment(3)=="trash"||$this->uri->segment(3)=="searched_queries")){ echo "class='active'"; } ?> class="manage_menu">
                                                <a href=""  >
                                                    <i class="fa fa-cog icon">
                                                        <b class="bg-dark"></b>
                                                    </i>
                                                    <span class="pull-right">
                                                        <i class="fa fa-angle-down text"></i>
                                                        <i class="fa fa-angle-up text-active"></i>
                                                    </span>
                                                    <span><?= lang('manage'); ?></span>
                                                </a>
                                                <ul class="nav lt">
                                                    <?php
                                                        if($this->permissions_model->check('users','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="users"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>users">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('users'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
//                                                        if($this->permissions_model->check('permissions','index')){
//                                                    ?>
<!--                                                    <li //<?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="permissions"){ echo "class='active'"; } ?>>
                                                        <a href="//<?= site_url().DASHBOARD_DIR_NAME ?>permissions">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span>//<?= lang('permissions'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
//                                                        }
                                                        if($this->permissions_model->check('languages','index')){
                                                    ?>
                                                   <!-- <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="languages"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>languages">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('languages'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('system_logs','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="system_logs"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>system_logs">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('system_logs'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('client_details','index') || $this->permissions_model->check('email_signature','index') || $this->permissions_model->check('date_format','index') || $this->permissions_model->check('website_logos','index') || $this->permissions_model->check('social_links','index') || $this->permissions_model->check('google_analytics','index') || $this->permissions_model->check('google_adsense','index') || $this->permissions_model->check('languages','index') || $this->permissions_model->check('email_settings','index') || $this->permissions_model->check('watermark_settings','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="general_settings"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('general_settings'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('subscribers','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="subscribers"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>subscribers">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('newsletter'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('contact_inquries','index')){
                                                    ?>
                                                    <!--<li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="contact_inquries"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>contact_inquries">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('contact_inquries'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('searched_queries','index')){
                                                    ?>
                                                    <!--<li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="searched_queries"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>searched_queries">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('searched_queries'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
                                                        }
//                                                        if($this->permissions_model->check('notifications','index')){
//                                                    ?>
<!--                                                    <li //<?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="notifications"){ echo "class='active'"; } ?>>
                                                        <a href="//<?= site_url().DASHBOARD_DIR_NAME ?>notifications">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span>//<?= lang('notifications'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
//                                                        }
//                                                        if($this->permissions_model->check('emails','index')){
//                                                    ?>
<!--                                                    <li //<?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="emails"){ echo "class='active'"; } ?>>
                                                        <a href="//<?= site_url().DASHBOARD_DIR_NAME ?>emails">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span>//<?= lang('emails'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
//                                                        }
//                                                        if($this->permissions_model->check('email_settings','index')){
//                                                    ?>
<!--                                                    <li //<?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="email_settings"){ echo "class='active'"; } ?>>
                                                        <a href="//<?= site_url().DASHBOARD_DIR_NAME ?>email_settings">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span>//<?= lang('email_settings'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
//                                                        }
                                                        if($this->permissions_model->check('migrations','index')){
                                                    ?>
                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="migrate"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>migrate">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('migrations'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        }
                                                        if($this->permissions_model->check('trash','index')){
                                                    ?>
<!--                                                    <li <?php if($this->uri->segment(2)=="dashboard"&&$this->uri->segment(3)=="trash"){ echo "class='active'"; } ?>>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>trash">                                           
                                                            <i class="fa fa-angle-right"></i>
                                                            <span><?= lang('trash'); ?></span>
                                                        </a>
                                                    </li>-->
                                                    <?php
                                                        }
                                                    ?>                                                    
                                                </ul>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </nav>
                                    <!-- / nav -->
                                </div>
                            </section>
                            <footer class="footer lt hidden-xs b-t b-dark">
                                <p style="color: #adbece;">&copy; <?= date('Y'); ?> <a href="<?= site_url(); ?>" target="_BLANK" style="color: #adbece;"><?= SITE_TITLE; ?></a></p>
                                <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                                    <i class="fa fa-angle-left text"></i>
                                    <i class="fa fa-angle-right text-active"></i>
                                </a>
                            </footer>
                        </section>
                    </aside>
