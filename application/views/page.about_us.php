<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    $this->load->view('_head.php');
?>

        <link rel="shortcut icon" href="/public_html/images/site-logo.png"/>
        <title><?= $page_title; ?></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>">
        <?php
            $keywords = "";
            $k = json_decode($about_us_details[0]['seo_keywords']);
            if(!empty($k)){
                foreach($k as $key){
                    if($keywords==""){
                        $keywords = $key->text;
                    }
                    else{
                        $keywords .= "|".$key->text;
                    }                
                }
            }
        ?>
        <meta name="keywords" content="<?= $keywords; ?>">
        <meta name="author" content=".com">
        <meta name="twitter:image:alt"    content="Image not found">
        <meta name="twitter:site" content="@tw">
        <meta name="twitter:creator" content="@tw">
        <meta name="twitter:title"        content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title']));; ?>">
        <meta name="twitter:description"  content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>">
        <meta name="twitter:image"        content="">
        <meta name="twitter:card"         content=".com">        
        <meta property="og:url"           content="<?= site_url(); ?>about_us" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title'])); ?>" />
        <meta property="og:description"   content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_desc'])); ?>" />
        <meta property="og:image"         content="" />
        <meta property="og:site_name"     content=".com">     
        <meta property="article:published_time" content="<?= date('Y-m-d\TH:m:sP',$about_us_details[0]['date_created']); ?>" />
        <meta property="article:modified_time" content="<?= date('Y-m-d\TH:m:sP',$about_us_details[0]['date_modified']); ?>" />
        <meta property="article:section" content="<?= str_replace('"', '', str_replace("'", "", $about_us_details[0]['seo_title'])); ?>" />
        <meta property="article:tag" content="<?= $keywords ?>" />
        <style>
            .mb-5{
                margin-bottom:5rem;
            }
        </style>
    </head>
    <body data-gr-c-s-loaded="true" class="js-focus-visible">

            <?php
            $this->load->view('block.head.php');
            ?>
        <main id="tg-main" class="tg-main tg-haslayout">
            <!--************************************
                            About Us Start
            *************************************-->
            <section class="tg-sectionspace tg-haslayout tg-paddingbottomzero">
                <div class="container">
                    <div class="row">
                        <div class="tg-aboutus tg-aboutusvtwo tg-aboutcreative">
                            <!--<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <h2><?= lang('from_the_editors_desk'); ?></h2>
                                <div style="margin-top: 20px;">
                                    <img src="/public_html/images/pratibadi.jpg" alt="Editor Pratibadi Kalam" class="img-responsive img-thumbnail" />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <div class="tg-description">
                                    <?php
                                        if(isset($about_us_details[0]['about_us'])){
                                            if($about_us_details[0]['about_us']!="<p><br></p>"){
                                                echo $about_us_details[0]['about_us'];
                                            }
                                            else{
                                                echo lang('not_available');
                                            }
                                        }
                                        else{
                                            echo lang('not_available');
                                        }
                                    ?>
                                </div>
                            </div>-->
                            <div class="col-md-12" style="padding:20px;">
                                <h3 class="text-center">প্রতিষ্ঠান সম্পর্কিত</h3>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/1.jpg" class="img-responsive"/>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-family: auto;margin-top: 20px;">
                                        Our newspaper ‘Pratibadi Kalam’ started publication in the year 2010 and our neutral journalism led us to be one of the largest circulated vernacular Bengali daily of Tripura. We earned a reputation of always being the first to bust scams and to have worked solely in public interest. In the year 2017 we were banned from publication on baseless grounds by the then District Magistrate of West Tripura. It was a big conspiracy involving ministers both from (ruling and opposition) whose involvement in various scams and ill doings where exposed by us back then. 
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <p style="font-family: auto;margin-top: 20px;">
                                        We went to the Press Registration and Appellate Board and fought for more than two and half years to have finally won. Even after which the DM didn’t give necessary permission and concern for us to resume publication. We had to again take the case to the Hon’ble High Court of Tripura.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/2.jpg" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/3.jpg" class="img-responsive"/>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-family: auto;margin-top: 20px;">
                                        The day we resumed publication which is on 28th November 2019, we started off with a full page report stating the 1200 Crore scam executed during the regime of Sri Manik Sarkar.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <p style="font-family: auto;margin-top: 20px;">
                                        Till then, we have receiving multiple threats involving destroying our newspaper copies, threatening our hawkers, vandalizing and burning our office on the historic of 8th September 2021, stopping publication of our English daily, excluding our leading ground from the cable provider loop and so on. 
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/4.jpg" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/5.jpeg" class="img-responsive"/>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="col-md-6">
                                    <p>
                                        
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <img src="/public_html/images/about_us/6.jpg" class="img-responsive"/>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--************************************
                            About Us End
            *************************************-->
        </main>

    <?php
    $this->load->view('block.foot.php');
    ?>