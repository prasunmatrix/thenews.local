<?php
    $this->load->view('page.stat.php');
    $this->load->view('_head.php');
    
?>
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
                        <section class="panel panel-default bg-white m-t-lg">
                            <header class="panel-heading">
                                <center><strong><?= lang('login'); ?></strong></center>
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
                                <button type="submit" class="btn btn-default sub_btn"><?= lang('login'); ?></button>
                                <!--<div class=""><hr></div>-->
                                    <center>
                                        
<!--<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>-->
<!--                                        <div scope="public_profile,email"
  onlogin="checkLoginState();" class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                        <br><br>
                                        <div class="g-signin2" data-onsuccess="onSignIn"></div>-->
                                    </center>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>login/register"><?= lang('create_an_account'); ?></a>
                                <a href="<?= site_url(); ?>login/forgot_password" class="pull-right"><?= lang('forgot_password'); ?></a>
                                <div class=""><hr></div>
                                <a href="<?= site_url(); ?>" class="btn btn-default btn-block"><?= sprintf(lang('go_back_to_main_site'),SITE_TITLE); ?></a>
                            </form>
                        </section>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                        
            </div>
        </section>
        <script>
             $(".login_form").submit(function(e){
                e.preventDefault();
                $(".sub_btn").prop('disabled',true);
                $(".sub_btn").html("<?= lang('please_wait'); ?>");
                $.ajax({
                    data: $(".login_form").serialize(),
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/users/user_login",
                    success: function (data) {
                        if (data.status) {
                            window.location = "<?= site_url() ?>";
                        } 
                        else {
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                if(data.next){
                                    window.location.href = data.next;
                                }
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