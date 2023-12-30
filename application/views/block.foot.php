        <div id="loginBannerModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="top:10%;">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button" class="close" data-dismiss="modal" style=" position: absolute; right: 10px; top: 5px; font-size: 30px; ">&times;</button>
                        <a href="#" id="bannerHref"><img src="/public_html/images/banner1.png"/></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="DownloadAppBannerModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="top:5%;">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button" class="close" data-dismiss="modal" style=" position: absolute; right: 10px; top: 5px; font-size: 30px; ">&times;</button>
                        <a href="#" onclick="openNewApp()" id="bannerHref"><img src="/public_html/images/banner2.png"/></a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="mobile-bottom-nav" style="display: none;">
            <div class="mobile-bottom-nav__item">
                <a href="<?= site_url(); ?>" style="color:#1c1c1c;">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fas fa-home" style='font-size:22px;'></i>
                    </div>
                </a>
            </div>
            
            <div class="mobile-bottom-nav__item">
                <a href="<?= site_url(); ?>epaper" style="color:#1c1c1c;">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="far fa-newspaper" style="color:#5cb85c;font-size:22px;"></i>
                    </div>
                </a>
            </div>
            
            <div class="mobile-bottom-nav__item">
                <a href="<?= site_url(); ?>district" style="color:#1c1c1c;">
                    <div class="mobile-bottom-nav__item-content">
                        <!--<img src='/public_html/images/1234.png' class='img-responsive' style='max-height:45px;margin:auto;'/>-->
                        <i class="fa fa-map-marker-alt" style="font-size:22px;"></i>
                    </div>
                </a>
            </div>
            
            <!--<div class="mobile-bottom-nav__item">
                <a href="<?= site_url() ?>exclusive_news" style="color:#1c1c1c;">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </a>
            </div>-->
            
            <div class="mobile-bottom-nav__item">
                <a href="<?= site_url().USER_PROFILE_DIR_NAME ?>" style="color:#1c1c1c;font-size:22px;">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
        </nav>
        <!--************************************
                Footer Start
        *************************************-->
        <footer id="tg-footer" class="tg-footer tg-footervtwo tg-bgdarkvtwo" style="padding: 50px 0px;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="tg-footerlogobar">
                            <strong class="tg-logo"><a href="javascript:void(0);(0);">
                                    <img src="/public_html/images/pratibadi-kalam-logo.png" alt="Pratibadi Kalam">
                                </a></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tg-footercolumns" style="padding-top: 20px;">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-4 col-lg-4">
                            <div class="tg-footercolumn tg-widget">
                                <ul>
                                    <li><a href="<?= site_url(); ?>about_us"><?= lang('who_we_are'); ?></a></li>
                                    <li><a href="<?= site_url(); ?>exclusive_news"><?= lang('exclusive_news'); ?></a></li>
                                    <li><a href="<?= site_url(); ?>live_news"><?= lang('live_news'); ?></a></li>
                                    <li><a href="<?= site_url(); ?>privacy_policy"><?= lang('privacy_policy'); ?></a></li>
                                    <li><a href="<?= site_url(); ?>terms"><?= lang('terms_and_conditions'); ?></a></li>
                                    <li><a href="<?= site_url(); ?>refund_policy"><?= lang('refund_policy'); ?></a></li>
                                    <li><a href="<?= site_url() ?>admin_login"><?= lang('admin_login'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="tg-footercolumn tg-widget">
                                <ul class="tg-socialicons">
                                    <li><a href="https://www.facebook.com/pratibadikalamOfficial/" target="_BLANK"><i class="icon-facebook-logo-outline"></i></a></li>
                                    <li><a href="https://twitter.com/kalampb24" target="_BLANK"><i class="icon-twitter-social-outlined-logo"></i></a></li>
                                    <li><a href="https://www.instagram.com/pratibadikalam.pb24" target="_BLANK"><i class="icon-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/channel/UClbNJCw6r11-DDP39hi-Ghg" target="_BLANK"><i class="icon-youtube"></i></a></li>
                                </ul>
                                <h4><?= lang('newsletter'); ?></h4>
                                <form class="tg-formtheme tg-formsubscribe">
                                    <fieldset>
                                        <input type="email" name="email" class="form-control sub_email_field" placeholder="<?= lang('enter_your_email_to_subscribe_newsletter'); ?>" style="text-transform: lowercase;" />
                                        <button type="submit" class="subscribe_sub_btn"><i class="icon-envelope"></i></button>
                                    </fieldset>
                                </form>
                                <span class="tg-copyright"><?= lang('copyright'); ?> &copy; <?= date('Y'); ?> <?= lang('pratibadi_kalam'); ?> <?= lang('all_rights_are_reserved'); ?>.</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-4 col-lg-4">
                            <div class="tg-footercolumn tg-widget" style="padding:40px 0px 40px 0px;">
                                <ul>
                                    <li><a href="<?= site_url() ?>district/view/district-north" ><?= lang('district_1'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-south" ><?= lang('district_2'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-gomati" ><?= lang('district_3'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-sepahijla" ><?= lang('district_4'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-unakati" ><?= lang('district_5'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-west" ><?= lang('district_6'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-khowei" ><?= lang('district_7'); ?></a></li>
                                    <li><a href="<?= site_url() ?>district/view/district-dhalai" ><?= lang('district_8'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--************************************
                Footer End
        *************************************-->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/service-worker.js', {scope: '/'});
                });
            }

function openNewApp(){
	window.location.href = "https://play.app.goo.gl/?link=https://play.google.com/store/apps/details?id=com.vrpatel.pratibadikalam";
}
        
            var FromEndDate = new Date();
            $(".datepicker").datepicker({
                endDate: FromEndDate, 
                autoclose: true,
                showOn: "button",
                buttonImage: "/public_html/images/email.png",
                buttonImageOnly: true

            }).on('change',function(){
                date = $("#tb_date").val();
                date_arr = date.split('/');
                window.location.href = "<?= site_url() ?>epaper/date/" + date_arr[2] + "/" + date_arr[0] + "/" + date_arr[1] + "/1";
            });      
            
            function setCookie(name,value,days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }
            function eraseCookie(name) {   
                document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }
            
            $(".tg-formsubscribe").submit(function(e){
                e.preventDefault();
                $(".subscribe_sub_btn").prop("disabled",true);
                $(".subscribe_sub_btn").html("<i class='fa fa-spin fa-spinner'></i>");
                $.ajax({
                    url: "<?= site_url(); ?>api/users/save_subscriber_details",
                    data:$(".tg-formsubscribe").serialize(),
                    type:"post",
                    dataType:"json",
                    success: function(res){
                        if(res.status){
                            alertify.alert("<?= lang('notifications'); ?>", res.message , function(){
                                $(".subscribe_sub_btn").prop("disabled",false);
                                $(".subscribe_sub_btn").html("<i class='icon-envelope'></i>");
                                $(".sub_email_field").val("");
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                        else{
                            alertify.alert("<?= lang('notifications'); ?>", res.message , function(){
                                $(".subscribe_sub_btn").prop("disabled",false);
                                $(".subscribe_sub_btn").html("<i class='icon-envelope'></i>");
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                    },
                    error: function(err){
                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){
                            $(".subscribe_sub_btn").prop("disabled",false);
                            $(".subscribe_sub_btn").html("<i class='icon-envelope'></i>");
                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                    }
                });
            });
            
            $(document).ready(function(e){
                function isMobile(){
                    const toMatch = [
                        /Android/i,
                        /webOS/i,
                        /iPhone/i,
                        /iPad/i,
                        /iPod/i,
                        /BlackBerry/i,
                        /Windows Phone/i
                    ];
                
                    return toMatch.some((toMatchItem) => {
                        return navigator.userAgent.match(toMatchItem);
                    });
                };
                
                if(isMobile()){
                    if(getCookie('displayed_landing_page')){
                        
                    }
                    else{
                        <?php
                            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                                if($_SERVER['HTTP_X_REQUESTED_WITH']=='com.pb24.pratibadikalam'||$_SERVER['HTTP_X_REQUESTED_WITH']=='com.vrpatel.pratibadikalam'){
                        ?>
                        setCookie('displayed_landing_page',1,30);
                        //window.location.href = "<?= site_url() ?>welcome";                
                        <?php
                                }
                            }
                        ?>
                    }
                }
                
                setTimeout(function(){ 
                    var _tg_portfolio = jQuery('[id="tg-filtermasonryvone"], [id="tg-filtermasonryvtwo"]');
                    if (_tg_portfolio.hasClass('tg-filtermasonry')) {
                        _tg_portfolio.isotope({
                            itemSelector: '.tg-masonrygrid',
                            percentPosition: true,
                            masonry: {
                                columnWidth: '.grid-sizer'
                            }
                        });
                    }
                    
                    var _tg_portfolio = jQuery('[id="tg-portfoliovthree"], [id="tg-portfoliovfive"]');
                    if (_tg_portfolio.hasClass('tg-portfolio')) {
                        _tg_portfolio.isotope({
                            itemSelector: '.tg-portfolioitem',
                            percentPosition: true,
                            masonry: {
                                columnWidth: '.grid-sizer'
                            }
                        });
                    }
    
                }, 1000);
                
                <?php
                    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                        if($_SERVER['HTTP_X_REQUESTED_WITH']=='com.pb24.pratibadikalam'||$_SERVER['HTTP_X_REQUESTED_WITH']=='com.vrpatel.pratibadikalam'){

                        }
                        else{
//                            if($_SERVER['HOST']!="thenews.local"){
{
                            ?>
                                setTimeout(function(){
                                    if(getCookie('displayDownloadAppBanner')){
                                        eraseCookie('displayDownloadAppBanner');
                                    }
                                    else{
                                        //setCookie('displayDownloadAppBanner',1,1);
                                        $("#DownloadAppBannerModal").modal('show');
                                    }
                                }, 5000);
                            <?php
                            }
                        }
                    }
                    else{
 //                       if($_SERVER['HOST']!="thenews.local"){
{
                        ?>
                            setTimeout(function(){
                                if(getCookie('displayDownloadAppBanner')){
                                    eraseCookie('displayDownloadAppBanner');
                                }
                                else{
                                    //setCookie('displayDownloadAppBanner',1,30);
                                    $("#DownloadAppBannerModal").modal('show');
                                }
                            }, 5000);
                        <?php
                        }
                    }
                ?>
            });
            function openLoginBanner(url){
                if(url==1){
    //                $("#bannerHref").attr("href","<?= site_url() ?>login");
			window.location.href = "<?= site_url(); ?>login";
                }
                else{
  //                  $("#bannerHref").attr("href","<?= site_url() ?>profile/subscription");

			window.location.href = "<?= site_url(); ?>profile/subscription";
                }
//                $("#loginBannerModal").modal('show');
            }
        </script>
        <script src="/public_html/js/vendor/jquery-library.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/vendor/bootstrap.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyCR-KEWAVCn52mSdeVeTqZjtqbmVJyfSus&language=en"></script>
        <script src="/public_html/js/jquery.singlePageNav.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/jquery-scrolltofixed.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/owl.carousel.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/jquery.vide.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/royalslider.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/scrollbar.min.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/isotope.pkgd.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/prettyPhoto.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/sticky-kit.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/countdown.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/parallax.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/collapse.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/countTo.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/appear.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/gmap3.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/main.js?v=<?= RELEASE_VERSION; ?>"></script>
        <script src="/public_html/js/jquery.zoom.js?v=<?= RELEASE_VERSION; ?>"></script>
    </body>
</html>
