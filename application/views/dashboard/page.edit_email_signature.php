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
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings"><i class="fa fa-gear"></i> &nbsp;<?= lang('general_settings'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/email_signature"><i class="fa fa-envelope-o"></i> &nbsp;<?= lang('email_signature'); ?></a></li>
                                    <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_email_signature'); ?></li>
                                </ul>
                                <div class="col-md-12" style="margin-top:10px;padding: 0px;">
                                    <form method="post" class="email_signature_form">                                        
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><i class="fa fa-file-text-o"></i> &nbsp;<?= lang('edit_email_signature'); ?></div>
                                                <div class="panel-body">
                                                    <?php
                                                        if(!empty($general_config)){
                                                            foreach($general_config as $config){
                                                                if($config['config_name']=='email_signature'){
                                                    ?>
                                                    <div class="">
                                                        <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                                                <ul class="dropdown-menu">
                                                                </ul>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a data-edit="fontSize 5"><font size="5"><?= lang('huge'); ?></font></a></li>
                                                                    <li><a data-edit="fontSize 3"><font size="3"><?= lang('normal'); ?></font></a></li>
                                                                    <li><a data-edit="fontSize 1"><font size="1"><?= lang('small'); ?></font></a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                                                <div class="dropdown-menu">
                                                                    <div class="input-group m-l-xs m-r-xs">
                                                                        <input class="form-control input-sm" placeholder="URL" type="text" data-edit="createLink"/>
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default btn-sm" type="button">Add</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a class="btn btn-default btn-sm" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                                            </div>

                                                            <div class="btn-group" style="width:34px">
                                                                <a class="btn btn-default btn-sm" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                                                <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-default btn-sm" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                                                <a class="btn btn-default btn-sm" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                                            </div>
                                                        </div>
                                                        <p><?= lang('this_text_would_be_used_as_signature_text_while_sending_all_emails'); ?></p>
                                                        <div id="editor" class="form-control" style="overflow-y: scroll;min-height: 200px;">
                                                            <?php if($config['config_value']!=""){ echo $config['config_value']; } ?>
                                                        </div>
                                                        <textarea name="email_signature" class="email_signature" style="display: none;"></textarea>
                                                    </div>
                                                    <?php                
                                                                }
                                                            }
                                                        }
                                                        else{
                                                            echo lang('no_data_found');
                                                        }
                                                    ?>
                                                    <div class="col-md-12" style="padding: 0px;margin-top: 20px;margin-bottom: 10px;">
                                                        <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                        <a href="<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/email_signature/" class="btn btn-default"><?= lang('cancel'); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </section>
                        </section>                           
                    </section>
                    <script type="text/javascript" src="/public_html/dashboard/js/wysiwyg/jquery.hotkeys.js"></script>
                    <script type="text/javascript" src="/public_html/dashboard/js/wysiwyg/bootstrap-wysiwyg.js"></script>
                    <script type="text/javascript" src="/public_html/dashboard/js/wysiwyg/demo.js"></script>
                    <script>
                        $(document).ready(function(e){
                            $(".email_signature_form").submit(function(e){
                                $(".email_signature").val($("#editor").html());
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                $.ajax({
                                    data: $(".email_signature_form").serialize(),
                                    type: "post",
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/general_settings/save_email_signature_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>general_settings/email_signature/";
                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();                                        
                                        } else {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                        }
                                        $(".submit_btn").html("<?= lang('save'); ?>");
                                        $(".submit_btn").prop("disabled",false);
                                    },
                                    error:function(err){
                                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){
                                            console.log();
                                            $(".submit_btn").html("<?= lang('save'); ?>");
                                            $(".submit_btn").prop("disabled",false);
                                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                    }
                                });
                            });
                        });
                        
                   </script>
<?php
    $this->load->view(DASHBOARD_DIR_NAME.'block.foot.php');
?>