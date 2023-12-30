<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'_head.php');
?>

    </head>
    <body>
        <?php
            $this->load->view(DASHBOARD_DIR_NAME.'block.head.php');
        ?>
            
                    <section id="content">
                        <section class="vbox">          
                            <section class="scrollable padder">
                                <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('home'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings"><i class="fa fa-cog"></i> &nbsp;<?= lang('general_settings'); ?></a></li>
                                    <li class="active"><i class="fa fa-language"></i> &nbsp;<?= lang('languages'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <i class="fa fa-gear"></i> &nbsp;<?= lang('languages'); ?>
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                    if(!empty($languages)){
                                                        foreach($languages as $language){
                                                            if($this->permissions_model->check('languages','edit')){
                                                            
                                                            ?>
                                                                <div class="col-md-12" style="padding-left: 0px;">
                                                                    <div class="col-xs-10" style="padding-left: 0px;">
                                                                        <p class="pull-right"><?= $language['language']; ?></p>
                                                                    </div>
                                                                    <div class="col-xs-2"><label class='switch'><input onchange='change_language_settings(<?= $language['lang_id']; ?>)' type='checkbox' id="lang_<?= $language['lang_id']; ?>" <?php if($language['visibility']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                                </div>
                                                            <?php
                                                            }
                                                            else{
                                                            ?>
                                                                <div class="col-md-12" style="padding-left: 0px;">
                                                                    <div class="col-xs-10" style="padding-left: 0px;">
                                                                        <p class="pull-right"><?= $language['language']; ?></p>
                                                                    </div>
                                                                    <div class="col-xs-2"><label class='switch'><input disabled type='checkbox' id="lang_<?= $language['lang_id']; ?>" <?php if($language['visibility']=='1'){ echo "checked"; } ?>><span></span></label></div>
                                                                </div>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-info-circle"></i> &nbsp;<?= lang('instructions'); ?>
                                                </div>
                                                <div class="panel-body">
                                                    <p><?= lang('using_this_page_you_can_manage_languages_in_the_entire_website'); ?></p>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>                           
                    </section>
        <script>
            function change_language_settings(per){
                if ($('#lang_'+per).prop('checked')){ permission = "1"; } else{ permission = "0"; }
                $.ajax({
                    data: {permission:permission, per:per},
                    type: "post",
                    dataType: 'json',
                    url: "<?= site_url() ?>api/general_settings/update_language_settings",
                    success: function (data) {
                        if(data.status){
                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                location.reload();
                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                        }
                        else{
                            alertify.notify(data.message, 'warning', 5, function(){  console.log('dismissed'); });
                        }
                    }
                });
            }
        </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>