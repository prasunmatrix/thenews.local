<?php
    $this->load->view('_head.php');
?>
        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title>PB 24 News</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index, follow">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="">
        <meta name="twitter:description"  content="">
        <meta name="twitter:image"        content="/public_html/images/site-logo.png">
        <meta name="twitter:card"         content="">        
        <meta property="og:url"           content="<?= site_url(); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="" />
        <meta property="og:description"   content="" />
        <meta property="og:image"         content="/public_html/images/site-logo.png" />
        <meta property="og:site_name"     content="">     
        <meta property="article:published_time" content="" />
        <meta property="article:modified_time" content="" />
        <meta property="article:section" content="" />
        <meta property="article:tag" content="" />
        <?php
            if(!empty($epapers)){
                foreach ($epapers as $page){
                    if($page['page_num']==$active_page){
                        $active_page_url = $page['thumbnail'];
                    }
                }
            }
        ?>
        <script src="/public_html/js/pinch-zoom.js?v=<?= RELEASE_VERSION; ?>"></script>
    </head>
    <body>
        <!--************************************
            Loader Start
        *************************************-->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!--************************************
            Loader End
        *************************************-->
        
        <?php
            $this->load->view('block.head.php');
        ?>

        <!--************************************
				Blog Post Start
		*************************************-->
        <main id="tg-main" style="margin-top: 80px;" class="tg-main tg-haslayout">
            <div class="container">
                <div class="row" style="padding: 0px;">
                    <div class="col-md-12">
                        <h3 class="text-center"><?php echo date($configs['date_format'],strtotime($y."-".$m."-".$d));  ?></h3>
                        <center>
                            <input type="text" class="datepicker" style="width:200px;" id="tb_date" placeholder="<?= lang('select_a_date'); ?>" autocomplete="off">
                        </center>
                        <hr style="margin-top: 8px;margin-bottom: 8px;">
                    </div>
                    <div class="col-md-12">
                        <?php
                            if(!empty($epaper_details)){
                                if($active_page>1){
                                    if($this->session->userdata('normal_user')){
                                        if($subscription_end_date!="0000-00-00" && time()> strtotime($subscription_end_date)){

                                            if($active_page_url!==""){
                                            $filename = $active_page_url;
                                            $filename_arr = explode(".", $filename);
                                            if(end($filename_arr)=="pdf"){
                                            ?>
						<iframe src="/public_html/upload/pdfs/<?= $active_page_url; ?>" title="PB 24 Epapers" style="width:100%;min-height:700px;margin-bottom:50px;"></iframe>
                                                <!--<div class="col-md-12" style="width:900px;padding: 0px;"><pinch-zoom style="width: 200%;height: 100%;background: #58545c;"><div id="printContainer" class="col-md-12"></div></pinch-zoom></div>-->
                                            <?php
                                            }
                                            else{
                                            ?>
                                                <div class="col-md-12" style="width:900px;padding: 0px;"><pinch-zoom style="width: 200%;height: 100%;background: #58545c;"><span class='zoom' id='epaper'><img src="<?= S3_URL.S3_BUCKET_NAME?>/images/<?= $active_page_url; ?>"/></span></pinch-zoom></div>
                                            <?php    
                                            }
                                                }
                                                else{
                                                    if(!empty($epapers)){
                                            ?>
                                            <p class="alert alert-danger text-center"><?= lang('invalid_page_number'); ?></p>
                                            <?php
                                                    }
                                                }
                                        }
                                        else{
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<div class='col-md-12'>";
                                            echo "<center><a href='#' onclick='openLoginBanner(2)' class='btn btn-default'>" . lang('please_subscribe_to_view_epaper') . "</a></center>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "</div>";
                                        }
                                    }
                                    else{

                                        echo "<br>";
                                        echo "<br>";
                                        echo "<div class='col-md-12'>";
                                        echo "<center><a href='#' onclick='openLoginBanner(1)' class='btn btn-default'>" . lang('please_login_to_view_epaper') . "</a></center>";
                                        echo "<br>";
                                        echo "<br>";
                                        echo "</div>";

                                    }
                                }
                                else{
                                    if($this->session->userdata('normal_user')){
                                        if($subscription_end_date!="0000-00-00" && time()< strtotime($subscription_end_date)){
                                            if($active_page_url!==""){
                                                $filename = $active_page_url;
                                                $filename_arr = explode(".", $filename);
                                                if(end($filename_arr)=="pdf"){
                                                ?>
						   <iframe src="/public_html/upload/pdfs/<?= $active_page_url; ?>" title="PB 24 Epapers" style="width:100%;min-height:700px;margin-bottom:50px;"></iframe>

                                                    <!--<div class="col-md-12" style="width:900px;padding: 0px;"><pinch-zoom style="width: 200%;height: 100%;background: #58545c;"><div id="printContainer" class="col-md-12"></div></pinch-zoom></div>-->
                                                <?php
                                                }
                                                else{
                                                ?>
                                                    <div class="col-md-12" style="width:900px;padding: 0px;"><pinch-zoom style="width: 200%;height: 100%;background: #58545c;"><span class='zoom' id='epaper'><img src="<?= S3_URL.S3_BUCKET_NAME?>/images/<?= $active_page_url; ?>"/></span></pinch-zoom></div>
                                                <?php    
                                                }

                                            }
                                            else{
                                                if(!empty($epapers)){
                                            ?>
                                                <p class="alert alert-danger text-center"><?= lang('invalid_page_number'); ?></p>
                                            <?php
                                                }
                                            }
                                        }
                                        else{
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<div class='col-md-12'>";
                                            echo "<center><a href='#' onclick='openLoginBanner(2)' class='btn btn-default'>" . lang('please_subscribe_to_view_epaper') . "</a></center>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "</div>";
                                        }
                                    }
                                    else{
                                        echo "<br>";
                                        echo "<br>";
                                        echo "<div class='col-md-12'>";
                                        echo "<center><a href='#' onclick='openLoginBanner(1)' class='btn btn-default'>" . lang('please_login_to_view_epaper') . "</a></center>";
                                        echo "<br>";
                                        echo "<br>";
                                        echo "</div>";
                                    }
                                }
                            }
                            else{
                                echo "<br>";
                                echo "<br>";
                                echo "<div class='col-md-12'>";
                                echo "<center><a href='#' class='btn btn-default'>" . lang('no_epaper_found') . "</a></center>";
                                echo "<br>";
                                echo "<br>";
                                echo "</div>";
                            }
                                
                             
                                        
                        ?>
                    </div>
                    </div>
<!--                    <hr style="margin-top: 8px;margin-bottom: 8px;">
                    <div class="col-md-12">
                        <?php
                            if(!empty($epapers)){
                                echo "<center><ul class='pagination'>";
                                foreach ($epapers as $page){
                                    if($page['page_num']==$active_page){
                                        $class_name = "active";
                                    }
                                    else{
                                        $class_name = "";
                                    }
                        ?>
                        <li class="<?= $class_name; ?>"><a href="<?= site_url() ?>epaper/date/<?= $y ?>/<?= $m ?>/<?= $d ?>/<?= $page['page_num'] ?>"><?= $page['page_num']; ?></a></li>
                        <?php
                                }
                                echo "</ul></center>";
                            }
                            else{
                        ?>
                        <p class="alert alert-warning text-center"><?= lang('no_epaper_found'); ?></p>
                        <?php
                            }
                        ?>
                    </div>-->
                </div>
            </div>
        </main>
        <?php
            if(!empty($epapers)){
                foreach ($epapers as $page){
                    if($page['page_num']==$active_page){
                        $active_page_url = $page['thumbnail'];
                        $filename = $page['thumbnail'];
                        $filename_arr = explode(".", $filename);
                        if(end($filename_arr)=="pdf"){
                    ?>
                        <script>
                            var url = "/public_html/upload/pdfs/<?= $active_page_url; ?>";
                        </script>
                        <script type="text/javascript" src="/public_html/pdfjs/lib/pdf.js/pdf.js"></script>
                        <script>
                            
                            var pdfjsLib = window['pdfjs-dist/build/pdf'];
                            pdfjsLib.GlobalWorkerOptions.workerSrc = '/public_html/pdfjs/lib/pdf.js/pdf.worker.js';

                            function renderPDF(url, canvasContainer, options) {

                                var options = options || { scale: 2 };

                                function renderPage(page) {
                                    var viewport = page.getViewport(options.scale);
                                    var canvas = document.createElement('canvas');
                                    var ctx = canvas.getContext('2d');
                                    var renderContext = {
                                      canvasContext: ctx,
                                      viewport: viewport
                                    };

                                    canvas.height = viewport.height;
                                    canvas.width = viewport.width;

                                    canvasContainer.appendChild(canvas);

                                    page.render(renderContext);
                                }

                                function renderPages(pdfDoc) {
                                    console.log(pdfDoc.numPages);
                                    for(var num = 1; num <= pdfDoc.numPages; num++){
                                        pdfDoc.getPage(num).then(renderPage);
                                    }
                                }

                                pdfjsLib.disableWorker = true;
                                pdfjsLib.getDocument(url).then(renderPages);

                            }  
                            renderPDF(url, document.getElementById('printContainer'));

                        </script>
                    <?php
                        }
                    }
                }
            }
        ?>
        <?php
            $this->load->view('block.foot.php');
        ?>
