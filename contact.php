<?php 
require_once 'app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';

include_once ROOT_PATH.'app/controllers/headerController.php';

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Contact Us | ';
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
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area section-space--pt_80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>Contact Us</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">Contact Us</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <div class="site-wrapper-reveal border-bottom">

        <div class="contact-us-info-area mt-30 section-space--mb_60">
            <div class="container">
                <div class="map-area">
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d132754.59382791136!2d79.82576654229649!3d6.8620593800563405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3ae25975cb94aaa5%3A0x8a2e3948edc00bbe!2scomfort%20world!3m2!1d6.8967228!2d79.8582514!5e0!3m2!1sen!2slk!4v1644826271702!5m2!1sen!2slk" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2003.4878804797622!2d79.85801040267384!3d6.896255891145321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25975cb94aaa5%3A0x8a2e3948edc00bbe!2sComfort%20World%20International!5e0!3m2!1sen!2slk!4v1644882975175!5m2!1sen!2slk" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        

        <div class="contact-us-info-area mt-30 section-space--mb_60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="single-contact-info-item" style="display: flex;">
                            <div class="icon">
                                <i class="icon-clock3"></i>
                            </div>
                            <div class="iconbox-desc">
                                <h6 class="mb-10">Open hours</h6>
                                <p>Mon – Fri : <br>8:30 AM – 6:00 PM<br><br>Sat – Sun :<br> 9:00 AM – 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single-contact-info-item">
                            <div class="icon">
                                <i class="icon-telephone"></i>
                            </div>
                            <div class="iconbox-desc">
                                <h6 class="mb-10">Phone number</h6>
                                <p><a href="tel:+ 94 (77) 266 3678">+ 94 (77) 266 3678</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single-contact-info-item">
                            <div class="icon">
                                <i class="icon-envelope-open"></i>
                            </div>
                            <div class="iconbox-desc">
                                <h6 class="mb-10">Our email</h6>
                                <p><a href="mailto:rest@comfortwi.lk">rest@comfortwi.lk</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single-contact-info-item">
                            <div class="icon">
                                <i class="icon-map-marker"></i>
                            </div>
                            <div class="iconbox-desc">
                                <h6 class="mb-10">Flagship Store</h6>
                                <p>No 175, Bauddhaloka Mawatha, <br>Colombo 7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-us-page-warpper section-space--pb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="border-top">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="contact-form-wrap  section-space--mt_60">
                                        <h5 class="mb-10">Get in touch</h5>
                                        <p>Write us a letter !</p>
                                        <form id="form-validate" class="mt-30" action="<?php echo URL?>app/controllers/enqireMailController.php" method="post">
                                            <div class="contact-form">
                                                <div class="contact-input">
                                                    <div class="contact-inner">
                                                        <input class="c-placeholder" type="text" name="name" id="name" placeholder="Name *">
                                                    </div>
                                                    <div class="contact-inner">
                                                        <input class="c-placeholder" id="email" name="email" type="email" placeholder="Email *">
                                                    </div>
                                                </div>
                                                <div class="contact-inner">
                                                    <input class="c-placeholder" name="subject" type="text" placeholder="Subject *">
                                                </div>
                                                <div class="contact-inner contact-message">
                                                    <textarea name="message" placeholder="Please describe what you need."></textarea>
                                                </div>
                                                <div class="submit-btn mt-20" style="float: right;">
                                                    <input type="hidden" name="send_contact_us_mail">
                                                    <button class="btn btn--brown btn--md submit_form_no_confirm" data-notify_type=2 type="button">Submit</button>
                                                    <p class="form-messege"></p>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- <div id="success">
						                    <p style="color: green !important;">Your message has been sent successfully.</p>
					                    </div>
					                    <div id="error">
						                    <p style="color: red !important;">Message cannot be sent!</p>
					                    </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <script src="https://www.google.com/recaptcha/api.js?render=6LeS7XgeAAAAAMDTLHBZ6CTo6WE7Tb9pZIjC913q"></script>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=6LeS7XgeAAAAALeufr3EU8DCXEdd4drCVgDHcaP2;ver=5.2.7"></script>

    <?php require_once ROOT_PATH.'imports/js.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="<?php echo URL?>assets/js/validation/contact.js"></script>
</body>

</html>
<script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>

<script>
    $('#contactus').addClass('active');
    /*--
        Google Map
        -----------------------------------*/

    // Google Map For Single Property Map
    $('.googleMap-1').each(function() {
        if ($(this).length) {
            var $this = $(this);
            var $lat = $this.data('lat');
            var $long = $this.data('long');

            function initialize() {
                var mapOptions = {
                    zoom: 14,
                    scrollwheel: false,
                    center: new google.maps.LatLng($lat, $long),
                    styles: [{
                            "featureType": "water",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#F1F1F1"
                            }]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [{
                                    "color": "#F1F1F1"
                                },
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#fff"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#fff"
                            }]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#F1F1F1"
                                },
                                {
                                    "weight": 1.8
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                "color": "#ECECEC"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#FF5151"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#fff"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#F1F1F1"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#ffffff"
                            }]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#F9F9F9"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#B7B7B7"
                            }]
                        },
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#8b8b8b"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                "color": "#d6d6d6"
                            }]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {},
                        {
                            "featureType": "poi",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#EBEBEB"
                            }]
                        }
                    ]
                };
                var map = new google.maps.Map(document.getElementById('googleMap-1'), mapOptions);
                var marker = new google.maps.Marker({
                    position: map.getCenter(),
                    icon: '',
                    map: map,
                    overlay: {
                        values: [{
                            address: "40.7590615,-73.969231",
                            position: 'center',
                            options: {
                                content: '',
                            }
                        }, ],
                        events: {
                            mouseover: function(overlay, event, context) {
                                var target = overlay.getDOMElement();

                                target.style.zIndex = 2;

                                var info = $(target).find('.gmap-info-wrapper');
                                info.find('.gmap-info-template').show();
                            },
                            mouseout: function(overlay) {
                                var target = overlay.getDOMElement();

                                target.style.zIndex = 1;

                                var info = $(target).find('.gmap-info-wrapper');
                                info.find('.gmap-info-template').hide();
                            }
                        }
                    },
                });
            };
            google.maps.event.addDomListener(window, 'load', initialize);
        }
    });
</script>