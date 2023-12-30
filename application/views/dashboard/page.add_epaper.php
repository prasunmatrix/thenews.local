<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php  $this->load->view('dashboard/_head.php'); ?>
        <style>
            .fr-box.fr-basic .fr-element.fr-view {
                font-family: "Times New Roman", Georgia, Serif;
                font-size: 18px;
                color: #444444;
            }
            .input-s {
                width: 65%;
            }
        </style>
    </head>
    <body class="">
    <?php $this->load->view('dashboard/block.head.php'); ?>
        
<?php } ?>
                        <title><?php echo $page_title; ?> - <?php echo lang('site_title'); ?></title>
                        <section class="vbox bg-gradient content-vbox">
                            <header class="header b-b b-t b-light bg-light lter">
                                <ul class="breadcrumb no-border no-radius">
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('dashboard'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>epaper"><i class="fa fa-newspaper-o"></i> &nbsp;<?= lang('epaper'); ?></a></li>
                                    <?php
                                        if($this->uri->segment(4)=='add'){
                                    ?>
                                        <li class="active"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_epaper'); ?></li>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_new_epaper'); ?></li>
                                    <?php        
                                        }
                                    ?>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="epaper_form">
                                            <div class="col-md-8 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php
                                                            if($this->uri->segment(4)=='add'){
                                                        ?>
                                                            <i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_epaper'); ?>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_new_epaper'); ?>
                                                        <?php        
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="hidden" name="epaper_id" class="form-control" value="<?php  if(isset($epaper_details[0]['epaper_id'])){ echo $epaper_details[0]['epaper_id']; }?>">
                                                                <input type="text" name="epaper_title" class="form-control epaper_title" placeholder="<?= lang('epaper_title'); ?>" value="<?php  if(isset($epaper_details[0]['epaper_title'])){ echo $epaper_details[0]['epaper_title']; }?>">
                                                            </div>
                                                        </div>
<!--                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </div>
                                                                <input type="text" name="epaper_url" class="form-control epaper_url" placeholder="<?= lang('epaper_url'); ?>" value="<?php  if(isset($epaper_details[0]['rand_id'])){ echo $epaper_details[0]['rand_id']; }?>">
                                                            </div>
                                                        </div>-->
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" name="epaper_date" class="form-control datepicker" placeholder="<?= lang('epaper_date'); ?>" value="<?php  if(isset($epaper_details[0]['epaper_date'])){ $date = $epaper_details[0]['epaper_date']; $date_arr = explode('-',$date); echo $date_arr[2]."/".$date_arr[1]."/".$date_arr[0]; }?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-tags"></i>
                                                                </div>
                                                                <?php
                                                                    $check_array = array();
                                                                    if(isset($epaper_topics)){
                                                                        foreach($epaper_topics as $topic){
                                                                            $check_array[] = $topic['topic_id'];
                                                                        }
                                                                    }
                                                                ?>
                                                                <select class="form-control select2 topics" name="topics[]" multiple> 
                                                                <?php
                                                                    foreach ($topics as $topic) {
                                                                        if(in_array($topic['topic_id'], $check_array)){
                                                                        ?>
                                                                            <option value="<?= $topic['topic_id']; ?>" selected><?= $topic['topic_name']; ?></option> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                        ?>
                                                                            <option value="<?= $topic['topic_id']; ?>"><?= $topic['topic_name']; ?></option> 
                                                                        <?php    
                                                                        }
                                                                    }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <input type="text" class="form-control" name="seo_title" placeHolder="<?= lang('seo_title'); ?>" value="<?php  if(isset($epaper_details[0]['seo_title'])){ echo $epaper_details[0]['seo_title']; }?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-keyboard-o"></i>
                                                                </div>
                                                                <div id="MyPillbox" class="pillbox clearfix">
                                                                    <?php
                                                                        $keywords = array();
                                                                        if(isset($epaper_details[0]['seo_keywords'])){                                                                             
                                                                            $keywords = json_decode($epaper_details[0]['seo_keywords']);
                                                                        }
                                                                    ?>
                                                                    <ul>
                                                                        <?php
                                                                            if(!empty($keywords)){
                                                                                foreach ($keywords as $key){
                                                                        ?>
                                                                                <li class="label bg-dark"><?= $key->text; ?></li>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        
                                                                        <input type="text"  placeHolder="<?= lang('add_new_keyword'); ?>">
                                                                        <input type="hidden" id="seo_keywords" name="seo_keyword">
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-header"></i>
                                                                </div>
                                                                <textarea class="form-control" rows="5" name="seo_desc" placeholder="<?= lang('seo_descriptions'); ?>"><?php  if(isset($epaper_details[0]['seo_desc'])){ echo $epaper_details[0]['seo_desc']; }?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">
                                                            <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                            <a href="<?= site_url() . DASHBOARD_DIR_NAME ?>epaper" class="btn btn-default"><?= lang('cancel'); ?></a>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-upload"></i> &nbsp;<?= lang('upload_epapers'); ?> <span class="pull-right" style="cursor: pointer;" onclick="add_new_page()"><i class="fa fa-plus"></i> &nbsp; <?= lang('add_new_page'); ?></span></div>
                                                        <div class="panel-body">
                                                            <?php
                                                                $total_pages = 1;
                                                                if(!empty($epapers)){
                                                                    foreach($epapers as $page){
                                                                        $total_pages = $page['page_num'];
                                                                        $filename = $page['thumbnail'];
                                                                        $filename_arr = explode(".", $filename);
                                                                        if(end($filename_arr)=="pdf"){
                                                            ?>
                                                            <div class="col-xs-12" style="padding: 0px;margin-bottom: 0px;">
                                                                <div class="col-xs-2" style="padding: 0px;margin-bottom: 0px;">
                                                                    <p class="pull-right">
                                                                        <!--<label for="epaper_image_1"><?= lang('page'); ?> <?= $page['page_num']; ?></label>-->
                                                                        &emsp;
                                                                    </p>                                                                    
                                                                </div>
                                                                <div class="col-xs-10" style="padding: 0px;margin-bottom: 0px;">
                                                                    <a href="#" onclick="openEpaper(<?= $page['page_num']; ?>,'<?= S3_URL.S3_BUCKET_NAME.'/pdfs/'. $page['thumbnail']; ?>')">
                                                                        <?= lang('click_here_to_open_epaper'); ?> <?= lang('page'); ?> <?= $page['page_num']; ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                        }
                                                                        else{
                                                            ?>
                                                            <div class="col-xs-12" style="padding: 0px;margin-bottom: 0px;">
                                                                <div class="col-xs-2" style="padding: 0px;margin-bottom: 0px;">
                                                                    <p class="pull-right"><label for="epaper_image_1"><?= lang('page'); ?> <?= $page['page_num']; ?></label>&emsp;</p>
                                                                    
                                                                </div>
                                                                <div class="col-xs-10" style="padding: 0px;margin-bottom: 0px;">
                                                                    <a href="<?= S3_URL.S3_BUCKET_NAME.'/images/'. $page['thumbnail']; ?>" data-lightbox="roadtrip">
                                                                        <img src="<?= S3_URL.S3_BUCKET_NAME.'/images/'.$page['s_thumbnail']; ?>" class="img-responsive" style="max-height:30px;"/>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                        }  
                                                                    }  
                                                                }
                                                                else{
                                                            ?>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 0px;">
                                                                <div class="col-md-2" style="padding: 0px;margin-bottom: 0px;">
                                                                    <p class="pull-right"><label for="epaper_image_1"><?= lang('page'); ?> 1</label>&emsp;</p>
                                                                </div>
                                                                <div class="col-md-10" style="padding: 0px;margin-bottom: 0px;">
                                                                    <input type="file" id="epaper_image_1" name="epaper_image_1" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <input type="hidden" name="epaper_pages_counter_start" value="<?= ($total_pages+1); ?>">
                                                            <input type="hidden" name="epaper_pages_counter" id="epaper_pages_counter" value="<?= $total_pages; ?>">
                                                            <div class="epaper_pages" style="padding: 0px;margin-bottom: 10px;">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                    
                                </div>
                            </section>
                        </section>
                        <div id="epaperModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title page_number"></h4>
                                    </div>
                                    <div class="modal-body epaper_body">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close'); ?></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <script>                            
                            function add_new_page(){
                                page_number = $("#epaper_pages_counter").val();
                                console.log(page_number);
                                html = "";
                                html += "<div class='col-md-12' style='padding: 0px;margin-bottom: 0px;'>";
                                    html += "<div class='col-md-2' style='padding: 0px;margin-bottom: 0px;'>";
                                        html += "<p class='pull-right'><label for='epaper_image_" + (parseInt(page_number)+1) + "'><?= lang('page'); ?> " + (parseInt(page_number)+1) + "</label>&emsp;</p>";
                                    html += "</div>";
                                    html += "<div class='col-md-10' style='padding: 0px;margin-bottom: 0px;'>";
                                        html += "<input type='file' id='epaper_image_" + (parseInt(page_number)+1) + "' name='epaper_image_" + (parseInt(page_number)+1) + "' data-icon='false' data-classButton='btn btn-default' data-classInput='form-control inline input-s'>";
                                    html += "</div>";
                                html += "</div>";
                                $("#epaper_pages_counter").val(parseInt(page_number)+1);
                                $(".epaper_pages").append(html);
                                
                            }
                            $(".epaper_form").submit(function(e){
                                    pills = $('#MyPillbox').pillbox('items');
                                    if(pills.length>0){
                                        $("#seo_keywords").val(JSON.stringify(pills));
                                    }                                        
                                    $("#epaper_desc").html($(".fr-view").html());                        
                                    e.preventDefault();                                
                                    $(".submit_btn").prop('disabled',true);
                                    $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                    form = $('.epaper_form')[0];
                                    data = new FormData(form);
                                    console.log(data);
                                    $.ajax({
                                        data: data,
                                        type: "post",
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        url: "<?= site_url() ?>api/epaper/save_epaper_details",
                                        success: function (data) {
                                            if (data.status) {
                                                alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                    window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>epaper/view/"+data.next;
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
                            
                        $(".epaper_title").bind("keyup change", function(e) {
                            name = $(".epaper_title").val();
                            name = name.toLowerCase();
                            slug = name.replace(/[^A-Z0-9]+/ig, "-");
                            $(".epaper_url").val(slug);
                        });

                        $(".epaper_url").bind("keyup change", function(e) {
                            $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                        });
                        $(function () {
                            $(".epaper_title").focus();
                            $('#edit').froalaEditor({
                                placeholderText: "<?= lang('write_epaper_descriptions_here'); ?>",

                                // Set the file upload URL.
                                type: "post",
                                imageUploadURL: "<?= site_url() ?>api/files/upload_image",
                                imageUploadParams: {
                                    id: 'my_editor'
                                },
                                imageDefaultWidth: 0,
                                // Set the file upload URL.
                                type: "post",
                                fileUploadURL:  "<?= site_url() ?>api/files/upload_file",
                                fileUploadParams: {
                                    id: 'my_editor'
                                },
                                // Set the epaper upload URL.
                                type: "post",
                                epaperUploadURL: "<?= site_url() ?>api/files/upload_epaper",
                                epaperUploadParams: {
                                    id: 'my_editor'
                                },
                            });
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_epaper_descriptions_here'); ?>");
                            $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                e.preventDefault();
                            });
                        });
                        function openEpaper(pageNum, URL){
                            console.log(pageNum);
                            console.log(URL);
                            $("#epaperModal").modal("show");
                            $(".page_number").html("<?= lang('page'); ?> " + pageNum);
                            $(".epaper_body").html("<iframe src='" + URL + "' style='width:100%;min-height:500px;'></iframe");
                        }
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
