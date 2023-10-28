<?php require_once 'app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'newsAndEvents/controller/newsControllerClass.php';
require_once ROOT_PATH.'app/controllers/galleryControllerClass.php';

$newsPostArray = $newsControllerObj->recentPosts(2);
$galleryArray = $galleryControllerObj->fetchGalleryItems();

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Gallery | ';
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
        <style>

.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none;
position: fixed;
z-index: 999;
padding-top: 100px;
left: 0;
top: 0;
width: 100%;
height: auto;
overflow: auto;
background-color: rgb(0,0,0);
background-color: rgba(0,0,0,0.9);
margin-top: 91px;
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
  width: auto;
height: auto;

}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
</head>

<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>  
      <!--====================  End of header area  ====================-->
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area section-space--pt_90 ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>The Gallery</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">The Gallery</li>
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

    <!-- Blog Page Area Start -->
    <div class="blog-page-wrapper section-space--pt_60 section-space--pb_120">
        <div class="container">
          <?php foreach ($galleryArray as $key => $singleGallery) {?>
            <div class="gallery-section mt-3 mb-5">
                <div class="section-topic ">
                    <h4 class="colour-brown text-center"><?php echo $singleGallery[0]['category']?></h4>
                </div>
                <div class="row clearfix">
                    <?php foreach ($singleGallery['details'] as $nkey => $value) {
                      if ($value['type'] == 'image') {?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 ">
                                <div class="new-container single-blog-item mt-40">
                                    <div class="content blog-thumbnail-box">
                                        <!-- <div class="content-overlay"></div> -->
                                        <img id="myImg_<?php echo $nkey?>" class="content-image myImg" src="<?php echo $value['media']?>"> <!--onclick="openModal();currentSlide('<?php //echo $nkey?>')"-->
                                          
                                          <div class="gallery-overlay">
                                              <div class="content-text"><?php echo $value['caption']?></div>
                                          </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                      <?php }else{?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="single-blog-item mt-40">
                                    <div class="blog-thumbnail-box img-hover">
                                        <div class="elendo-video-box remove-gallery-image">
                                            <div class="video-icon">
                                                <!-- <a href="video here" id="video-autoplay" class="popup-youtube on-hover-text"><i class="linear-ic-play"></i></a>
                                                <div class="middle"><?php echo $value['caption']?></div> -->
                                                
                                                  <a href="https://www.youtube.com/watch?v=<?php echo $value['media']?>" id="video-autoplay" class="popup-youtube on-hover-text">
                                                  <img src="https://img.youtube.com/vi/<?php echo $value['media']?>/hqdefault.jpg" alt="" style="top: -150px;
position: absolute;
right: 155px;">
                                                  <i class="linear-ic-play"></i>                                              
                                                </a>
                                                <div class="middle"><?php echo $value['caption']?></div>
                                                <!-- <img src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" /> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="myModal" class="modal">
                              <span id="close_<?php echo $nkey?>" class="close">&times;</span>
                              <img class="modal-content" id="img_<?php echo $nkey?>">
                              <div id="caption"></div>
                            </div>
                        <?php  }
                        }?>
                </div>
            </div>
            <?php  }?>
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
    <?php require_once 'imports/js.php' ?>


    <script>

    $('#gallery').addClass('active');

      function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

    </script>

<!-- The Modal -->
<?php //foreach ($galleryArray as $key => $singleGallery) {
   //foreach ($singleGallery['details'] as $nkey => $value) { ?>
    

    <!-- <script>

      function openModal() {
        document.getElementById("myModal").style.display = "block";
      }
      // Get the modal
      var modal = document.getElementById("myModal");

      // Get the image and insert it inside the modal - use its "alt" text as a caption
      var img = document.getElementById("myImg_<?php echo $nkey?>");
      var modalImg = document.getElementById("img_<?php echo $nkey?>");
      var captionText = document.getElementById("caption");
      img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
      }

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() { 
        alert('called')
        modal.style.display = "none";
      }

      // $("#close_<?php echo $nkey?>").click(function() {
      //   alert( " called" );
      //   modal.style.display = "none";
      // });
  </script> -->
<?php //} 
//}?>

</body>
</html>