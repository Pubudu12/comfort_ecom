
<?php require_once 'app/global/url.php';  
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Terms & Conditions | ';
        $meta_single_page_desc = '';
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => URL.'assets/images/meta/home.jpg',
            
            'og:title' => $meta_single_page_title,
            'og:image' => URL.'assets/images/meta/home.jpg',
            'og:description' => $meta_single_page_desc,

            'twitter:image' => URL.'assets/images/meta/home.jpg',
            'twitter:title' => $meta_single_page_title,

        );
        require_once ROOT_PATH.'app/meta/meta_more_details.php'; 
        ?>

    <!-- CSS
        ============================================ -->

        <?php require_once 'imports/css.php' ?>

</head>
<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->
    <!-- <div class="container">
  <h1>Slider</h1>
      <div class="slider center">       
          <div class="slide">
            <div class="cl cl-yellow"></div>
          </div>
          <div class="slide">
            <div class="cl cl-blue"></div>
          </div>
          <div class="slide">
            <div class="cl cl-red"></div>
          </div>
          <div class="slide">
            <div class="cl cl-yellow"></div>
          </div>
          <div class="slide">
            <div class="cl cl-blue"></div>
          </div>
          <div class="slide">
            <div class="cl cl-red"></div>
          </div>
          
      </div>
      <div class="pagination"></div>
</div> -->

    <div class="breadcrumb-area section-space--pt_80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row breadcrumb_box  align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                                <h2 class="breadcrumb-title colour-brown"><b>Terms & Conditions</b></h2>
                            </div>
                            <div class="col-lg-6  col-md-6 col-sm-6">
                                <!-- breadcrumb-list start -->
                                <ul class="breadcrumb-list text-center text-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                    <li class="breadcrumb-item active">Terms & Conditions</li>
                                </ul>
                                <!-- breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="site-wrapper-reveal border-bottom">
        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_40 section-space--pb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Single Blog Item Start -->
                        <div class="single-blog-item">
                            
                            <div class="blog-contents">
                                <!-- <h3 class="blog-title-lg"><a href="#">Interior design is the art, the interior designer is the artist.</a></h3> -->

                                <div class="row">
                                    <div class="col-lg-12">

                                        <p class="mt-20 text-center mb-5">YOUR USE OF THE WEBSITE OF COMFORT WORLD INTERNATIONAL (PVT) LTD. (HEREIN CALLED “COMFORT WORLD”) IS SUBJECT TO THE FOLLOWING TERMS AND CONDITIONS. WHEN YOU ACCESS, BROWSE OR USE THIS WEBSITE, YOU ACCEPT WITHOUT LIMITATION THESE TERMS AND CONDITIONS.</p>

                                        <h5 class="mt-5 topic-color underline">OWNERSHIP OF INTELLECTUAL PROPERTY</h5>

                                        <p class="mt-20 ">All content included on this website, such as text, photographs, graphics, logos, scripts, trade names and service names, button icons, images, and audio clips, digital downloads, data compilations and software, is the property of COMFORT WORLD, its affiliates, its licensors or other content suppliers and to the extent applicable is protected by international copyright, trademark and patent laws and other laws protecting intellectual property rights.  All trademarks not owned by COMFORT WORLD or its affiliates that appear on this website are the property of their respective owners. </p>

                                        <h5 class="mt-5 topic-color underline">WEBSITE ACCESS AND USE</h5>

                                        <p class="mt-20 ">COMFORT WORLD grants you a limited license to access and use this website only for its intended purpose, which is to enable you to purchase COMFORT WORLD products and obtain information concerning our products and related services.  Under no circumstances are you to download or reproduce any portion of this website for any purpose, except as provided in the next paragraph.  You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including photographs, images, text, page layout or form) of COMFORT WORLD, its affiliates, licensors and other content suppliers without COMFORT WORLD’s prior written consent, which may be withheld in COMFORT WORLD’s sole and absolute discretion. You may not use any meta tags or any other "hidden text" utilizing COMFORT WORLD’s name or trademarks without the prior written consent of COMFORT WORLD, which may be withheld in COMFORT WORLD’s sole and absolute discretion.  Any unauthorized use of this website or its contents automatically terminates the license granted by COMFORT WORLD to access and use the website.  Further, you are hereby advised that any such unauthorized use of this website or its contents may violate applicable laws and governmental regulations governing the protection and use of intellectual property and that COMFORT WORLD and its affiliates reserve the rights to institute legal action against persons violating these Terms of Use.
                                            Notwithstanding the foregoing, you may use information such as articles, newsletters and similar materials purposely made available by COMFORT WORLD for downloading from the Website, provided that (1) you do not remove any proprietary notice language from such materials; (2) you use such information only for your personal non-commercial informational purposes; and (3) you do not copy or post such information on any networked computer or broadcast or transmit it in any media.</p>

                                        <h5 class="mt-5 topic-color underline">INFORMATION PROVIDED BY YOU</h5>
                                        
                                        <p class="mt-20 ">You may be asked to register a username and password in order to purchase products.  You represent and warrant to COMFORT WORLD that all information that you provide in connection with or in support of your registration for use of this website will be accurate and complete and will be kept up to date. COMFORT WORLD will be entitled to grant access to the website to anyone using your user name and password, unless you have previously notified COMFORT WORLD in writing of any unauthorized use of your account. </p>

                                        <h5 class="mt-5 topic-color underline">MEDICAL WARNING </h5>

                                        <p class="mt-20 ">THIS WEBSITE AND ITS CONTENTS ARE INTENDED ONLY TO PROVIDE YOU WITH SUGGESTIONS FOR THE COMFORTABLE AND HEALTHFUL USE OF COMFORT WORLD PRODUCTS, WHICH WE RECOMMEND YOU CONFIRM IN CONSULTATION WITH YOUR PHYSICIAN.  Under no circumstances are this website and its contents to be considered medical advice, a recommended form of treatment or therapy for any medical, mental or emotional condition, a diagnostic tool or device for treating any disease, disorder or other condition, a preventative measure, cure, mitigation or treatment for any disease or disorder or as affecting the structure or well being of any part of the body. </p>

                                        <h5 class="mt-5 topic-color underline">DISCLAIMER AND LIMITATION OF LIABILITY</h5>

                                        <p class="mt-20 ">This website and the photographs, images, text and other content on this website are “as is” and COMFORT WORLD  makes no warranty or representation that any content, service or feature will be error-free or that any defects will be corrected or that your use of the Website or its content will provide specific results.  COMFORT WORLD hereby DISCLAIMS ALL WARRANTIES CONCERNING OR RELATING TO THIS WEBSITE AND THE PHOTOGRAPHS, IMAGES, TEXT AND OTHER CONTENT ON THIS WEBSITE, WHETHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.  IN NO EVENT  SHALL COMFORT WORLD BE LIABLE FOR SPECIAL, INDIRECT, PUNITIVE, INCIDENTAL OR CONSEQUENTIAL DAMAGES, WHETHER IN CONTRACT, WARRANTY, TORT, NEGLIGENCE, STRICT LIABILITY OR OTHERWISE including, but not limited to, loss of profits of revenue, loss of use, loss of data or any other damages arising out of, connected with or related to (1) the use or inability to use this website, (2) the use of  photographs, images, text or other content on this website, (3) unauthorized access to or alteration of your transmissions of data from this website, (4) statements or the conduct of any third party on this website or (5) any other matter relating to the website.</p>

                                        <h5 class="mt-5 topic-color underline">INDEMNIFICATION</h5>
                                        
                                        <p class="mt-20 ">You agree to indemnify, defend, and hold harmless COMFORT WORLD and its affiliates and their directors, officers, employees, content providers, licensors (collectively, "Indemnified Parties”) from and against any and all losses, damages, liabilities and costs (including, without limitation, attorneys' fees and disbursements), incurred by the Indemnified Parties in connection with any claim arising out of any breach by you of these Terms of Use.  You will cooperate at your expense as fully as reasonably required in COMFORT WORLD’s defense of any such claim. COMFORT WORLD reserves the right, at its own expense, to assume the exclusive defense and control of any claim subject to indemnification by you and you shall not in any event settle any such claim without the written consent of COMFORT WORLD.</p>

                                        <h5 class="mt-5 topic-color underline"> WEBSITE POLICIES, MODIFICATION, AND SEVERABILITY</h5>

                                        <p class="mt-20">We reserve the right to make changes to our website, policies, and these Terms of Use at any time. If any of these terms and conditions shall be deemed invalid, void, or for any reason unenforceable, that term or condition shall be deemed severable and shall not affect the validity and enforceability of any remaining terms and conditions.</p>

                                    </div>
                                </div>
                            </div>
                        </div><!-- Single Blog Item End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Page Area End -->
    </div>
    <!--====================  footer area ====================-->
    <?php require_once ROOT_PATH.'imports/footer.php' ?>
    <!--====================  End of footer area  ====================-->
    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top icon-arrow-up"></i>
        <i class="arrow-bottom icon-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->
    <!-- JS
    ============================================ -->
    <?php require_once 'imports/js.php' ?>
</body>
</html>