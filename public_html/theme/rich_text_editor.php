<?php
	$conn = mysqli_connect('localhost','root','123456','test');
    $qry = "select * from test";
    $res = mysqli_query($conn,$qry);
?>

<!DOCTYPE html>
<html lang="en" class="app">
    <head>
        <meta charset="utf-8" />
        <title>Notebook | Web Application</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="css/animate.css" type="text/css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="css/font.css" type="text/css" />
        <link rel="stylesheet" href="js/select2/select2.css" type="text/css" />
        <link rel="stylesheet" href="js/select2/theme.css" type="text/css" />
        <link rel="stylesheet" href="js/fuelux/fuelux.css" type="text/css" />
        <link rel="stylesheet" href="js/datepicker/datepicker.css" type="text/css" />
        <link rel="stylesheet" href="js/slider/slider.css" type="text/css" />
        <link rel="stylesheet" href="css/app.css" type="text/css" />
        <!--[if lt IE 9]>
          <script src="js/ie/html5shiv.js"></script>
          <script src="js/ie/respond.min.js"></script>
          <script src="js/ie/excanvas.js"></script>
        <![endif]-->
    </head>
    <body class="">
        <section class="vbox">
            <section>
                <section class="hbox stretch">
                    <section id="content">
                        <section class="vbox">
                            <div class="">
                                <div class="col-md-7">
                                    <section class="scrollable padder">
                                        <div class="line line-dashed line-lg pull-in"></div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
                                                    <div class="btn-group">
                                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                        </ul>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                                            <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                                            <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
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
                                                <form method="post" class="test_form">
	                                                <div id="editor" class="form-control" style="overflow:scroll;min-height:400px;">

	                                                </div>
	                                                <button type="submit" class="btn btn-success sub_btn" style="
	                                                margin-top:20px;">Save</button>
                                            	</form>
                                            </div>
                                        </div>      
                                    </section>
                                </div>
                                <div class="col-md-5" style="margin-top: 30px;">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Your data</div>
                                        <div class="panel-body table-responsive">
                                            <?php
                                                while($d = mysqli_fetch_array($res)){
                                                    print_r($d['data']);
                                                }
                                            ?>  
                                        </div>
                                    </div>
                                </div>
                            </div>                
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.js"></script>
        <!-- App -->
        <script src="js/app.js"></script> 
        <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- fuelux -->
        <script src="js/fuelux/fuelux.js"></script>
        <!-- datepicker -->
        <script src="js/datepicker/bootstrap-datepicker.js"></script>
        <!-- slider -->
        <script src="js/slider/bootstrap-slider.js"></script>
        <!-- file input -->  
        <script src="js/file-input/bootstrap-filestyle.min.js"></script>
        <!-- combodate -->
        <script src="js/libs/moment.min.js"></script>
        <script src="js/combodate/combodate.js"></script>
        <!-- select2 -->
        <script src="js/select2/select2.min.js"></script>
        <!-- wysiwyg -->
        <script src="js/wysiwyg/jquery.hotkeys.js"></script>
        <script src="js/wysiwyg/bootstrap-wysiwyg.js"></script>
        <script src="js/wysiwyg/demo.js"></script>
        <!-- markdown -->
        <script src="js/markdown/epiceditor.min.js"></script>
        <script src="js/markdown/demo.js"></script>
        <script src="js/app.plugin.js"></script>
        <script>
        	$(".test_form").submit(function(e){
        		e.preventDefault();
        		$(".sub_btn").prop('disabled',true);
        		$(".sub_btn").html('Please wait...');
        		// contents = $("#editor").cleanHtml();
        		// $("#editor").text(contents);
        		$.ajax({
                    data: {data:$("#editor").html()},
                    type: "post",
                    dataType: 'json',
                    url: "save.php",
                    success: function (data) {
                        if(data.status){
                            location.reload();
                        }
                        else{
                            alert(data.message);
                        }
                    }
                });
        	});
        </script>
    </body>
</html>