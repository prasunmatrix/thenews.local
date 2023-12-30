<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
        <title><?= $page_title; ?></title>
        <style>
            textarea, select, .tg-select select, .form-control, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{ text-transform: none;}
            .btn-default {
                color: #fff;
                background-color: #333;
                border-color: #ccc;
            }
            body{
                font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
            }
        </style>
    </head>
    <body class="">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId=337142391335995&autoLogAppEvents=1" nonce="BH9Se4aV"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="6101634810-du4d1k0ur18vsriq0vmht971u6n0utid.apps.googleusercontent.com">
        <?php
            $this->load->view('block.head.php');
        ?>
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp" style="padding-top: 100px;background: url(/public_html/images/website-backgrounds.jpg);">    
            <div class="container aside-xxl">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4" style="padding: 0px 15px;">
                        <?php
                            if(isset($error)){
                                if($error!=""){
                                    ?>
                                        <p class="alert alert-danger text-center"><?= $error; ?></p>    
                                    <?php
                                }
                            }
                            else{
                        ?>
                        <section class="panel panel-default bg-white m-t-lg">
                            <header class="panel-heading">
                                <center><strong><?= lang('change_password'); ?></strong></center>
                            </header>
                            <form class="panel-body wrapper-lg change_password_form" method="post">
                                <div class="form-group">
                                    <label class="control-label"><?= lang('password'); ?></label>
                                    <input type="hidden" name="user_id" class="form-control input-lg" value="<?= $user_id; ?>" autofocus>
                                    <input type="password" name="password" class="form-control input-lg" value="" autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= lang('confirm_password'); ?></label>
                                    <input type="password" name="confirm_password" id="inputPassword" class="form-control input-lg" value="">
                                </div>
                                <button type="submit" class="btn btn-default sub_btn"><?= lang('change_password'); ?></button>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>login/login"><?= lang('login'); ?></a>
                                <a href="<?= site_url(); ?>login/register" class="pull-right"><?= lang('create_an_account'); ?></a>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>" class="btn btn-default btn-block"><?= sprintf(lang('go_back_to_main_site'),SITE_TITLE); ?></a>
                            </form>
                        </section>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                        
            </div>
        </section>
        <script>
             $(".change_password_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data: $(".change_password_form").serialize(),
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/users/reset_password",
                    success: function (data) {
                        if (data.status) {
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                isMobile = false;
                                if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
                                    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
                                    isMobile = true;
                                }
                                <?php
                                    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                                        if($_SERVER['HTTP_X_REQUESTED_WITH']=='com.vrpatel.pratibadikalam'){
                                ?>
                                    isMobile = false;
                                <?php
                                        }
                                    }
                                ?>
                                if(isMobile){
                                    window.location = "<?= site_url() ?>users/open_app_for_login";    
                                }
                                else{
                                    window.location = "<?= site_url() ?>login";    
                                }
                                
                                
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        } 
                        else {
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                    
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                        $(".sub_btn").html("<?= lang('change_password'); ?>");
                        $(".sub_btn").prop("disabled",false);
                    },
                    error:function(err){
                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_inetrnal_error'); ?>" , function(){
                            console.log();
                            $(".sub_btn").html("<?= lang('change_password'); ?>");
                            $(".sub_btn").prop("disabled",false);
                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                    }
                });
            });
        </script>
        
        
        <script>
  
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

    window.onload = function(){
        FB.getLoginStatus(function(response) {
			if(response.authResponse){
                statusChangeCallback(response);
			}
        });
    };
    

    function checkLoginState() {
      FB.getLoginStatus(function(response) {
          if(response.authResponse){
            statusChangeCallback(response);
          }
      });
    }

    function statusChangeCallback(response) {
        console.log(response.authResponse.userID);
		/*if(response.authResponse.accessToken){
	        console.log(response.authResponse.accessToken);			
		}*/

        
		if (response.status === 'connected') {

			var large_profile_picture_url = "";
			
			FB.api("/"+response.authResponse.userID+"/picture?height=250&width=250&redirect=false",
				function (response) {
				  if (response && !response.error) {
					large_profile_picture_url = response.data.url;
				  }
				}
			);

            FB.api('/me',{ locale: 'en_US', fields: 'name, email,picture' }, function (response) {
				
                /*console.log(JSON.stringify(response));
                console.log(large_profile_picture_url);
                html = "";
                html += "<br><br>User ID: " + response.id;
                html += "<br><br>User Name: " + response.name;
                html += "<br><br>User Email: " + response.email;
                html += "<br><br>User Profile Picture: <img src='" + response.picture.data.url + "'>";
                if(large_profile_picture_url!=""){
					html += "<br><br>User Profile Picture: <img src='"+large_profile_picture_url+"'>";
				}
				else{
					console.log('variable missing'+large_profile_picture_url);	
				}
                document.getElementById('status').innerHTML = html;
				*/
                save_social_login_data('Facebook',response,large_profile_picture_url);

            });
        } else {
            // The person is not logged into your app or we are unable to tell.
            document.getElementById('status').innerHTML = 'Please log into this app.';
        }
    }
    function logOut(){
        FB.logout(function(response) {
          // user is now logged out
          location.reload();
        });
    }
	
	function save_social_login_data(oauth_provider,user_obj,profile_picture_large){
		
		oauth_uid = "";
		name = "";
		email = "";
		picture = "";
		
		if ('id' in user_obj){
			oauth_uid = user_obj.id;
		}
		if ('name' in user_obj){
			name = user_obj.name;
		}
		if ('email' in user_obj){
			email = user_obj.email;
		}
		if(profile_picture_large!=""){
			picture = profile_picture_large;	
		}
		else{
			if ('url' in user_obj.picture.data){
				picture = user_obj.picture.data.url;
			}
		}
		
		$.ajax({
			data: {oauth_provider:oauth_provider,oauth_id:oauth_uid,full_name:name,email:email,picture:picture},
			type: "post",
			dataType: 'json',
			url: "<?= site_url() ?>api/users/user_social_login",
			success: function (data) {
				if(data.status){
					window.location.href = data.next;
				}
				else{
					console.log(data.message);
				}
			},
			error: function(err){
				console.log(err);
			}
		 });
		
		
	}
  </script>

        <?php
            $this->load->view('block.foot.php');
        ?>
    </body>
</html>