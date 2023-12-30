<?php
            $menu_items_table= 'menu_items';
            $menu_sub_items_table= 'menu_sub_items';
            $nav_menus = $this->users_model->get_where($menu_items_table,array('deleted'=>'0','visibility'=>'1'));
        ?>
        <!--************************************
            Header Start
        *************************************-->
        <div id="tg-wrapper" class="tg-wrapper tg-haslayout">
            <header id="tg-header" class="tg-header tg-headervone tg-fixedheader" style="background: black;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="tg-headercontent">
                           
                            
                            <nav id="tg-nav" class="tg-nav tb24_mobile_nav">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                            data-target="#tg-navigation" aria-expanded="false" style="border:none;">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div id="tg-navigation" class="collapse navbar-collapse tg-navigation dropdown">
                                    <ul>
                                        <?php
                                            foreach($nav_menus as $item){
                                                //get submenus
                                                $nav_sub_menus = $this->users_model->get_where($menu_sub_items_table,array('parent_item_id'=>$item['item_id'],'deleted'=>'0','visibility'=>'1'));
                                                if(!empty($nav_sub_menus)){
                                        ?>
                                                <li>
                                                    <a href="#" class="material-button submenu-toggle">
                                                        <?= $item['item_title']; ?> &nbsp;<i class="fa fa-caret-down"></i>
                                                    </a>
                                                    <div class="dropdown-content">
                                                        <ul style="margin-left:0px;">
                                                            <?php
                                                                foreach ($nav_sub_menus as $menu){
                                                            ?>
                                                            <li><a href="<?= site_url().$menu['sub_item_href']; ?>"><?= $menu['sub_item_title']; ?></a></li>
                                                            <?php
                                                                }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                        <?php
                                                }
                                                else{                       
                                                    if($item['item_href']=="epaper"){
                                        ?>
                                                <li class="epaper_item">
                                                    <a href="<?= site_url().$item['item_href']; ?>" class="material-button submenu-toggle">
                                                        <?= $item['item_title']; ?>
                                                    </a>
                                                </li>
                                        <?php                
                                                    }
                                                    else{
                                        ?>
                                                <li>
                                                    <a href="<?= site_url().$item['item_href']; ?>" class="material-button submenu-toggle">
                                                        <?= $item['item_title']; ?>
                                                    </a>
                                                </li>
                                        <?php                
                                                    }
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </nav>
                            
                             <strong class="tg-logo tb24_logo" style=" height: 50px;">
                                <a href="<?= site_url(); ?>videos">
                                    <img src="/public_html/images/pb24.png" alt="Pratibadi Kalam" style="height: 90%;">
                                </a>
                            </strong>
                            <strong class="tg-logo tb24_heading" style="margin: 15px 0 0px 0px;">
                                <center>
                                    <a href="<?= site_url(); ?>" class="text-center">
                                        <img src="/public_html/images/pratibadi-kalam.png" alt="Pratibadi Kalam">
                                        <img src="/public_html/images/pratibadi-kalam-black.png" alt="Pratibadi Kalam">
                                    </a>
                                </center>
                            </strong>
                            
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <!--************************************
            header end
        *************************************-->