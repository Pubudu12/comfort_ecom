  <!-- Modernizer JS -->
  <script src="<?php echo URL?>assets/js/vendor/modernizr-2.8.3.min.js"></script>

<!-- jQuery JS -->
<script src="<?php echo URL?>assets/js/vendor/jquery-3.3.1.min.js"></script>
<!-- popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script>
    ROOT_URL = '<?php echo URL ?>';
</script>

<!-- Bootstrap JS -->
<script src="<?php echo URL?>assets/js/vendor/bootstrap.min.js"></script>

<!-- Fullpage JS -->
<script src="<?php echo URL?>assets/js/plugins/fullpage.min.js"></script>

<script src="<?php echo URL ?>admin/assets/js/vendors/owlcarousel/owl.carousel.js"></script>

<script src="<?php echo URL ?>admin/assets/js/dashboard/product-carousel.js"></script>

<!-- Slick Slider JS -->
<script src="<?php echo URL?>assets/js/plugins/slick.min.js"></script>

<!-- Countdown JS -->
<script src="<?php echo URL?>assets/js/plugins/countdown.min.js"></script>

<!-- Magnific Popup JS -->
<script src="<?php echo URL?>assets/js/plugins/magnific-popup.js"></script>

<!-- Easyzoom JS -->
<script src="<?php echo URL?>assets/js/plugins/easyzoom.js"></script>

<!-- ImagesLoaded JS -->
<script src="<?php echo URL?>assets/js/plugins/images-loaded.min.js"></script>

<!-- Isotope JS -->
<script src="<?php echo URL?>assets/js/plugins/isotope.min.js"></script>

<!-- YTplayer JS -->
<script src="<?php echo URL?>assets/js/plugins/YTplayer.js"></script>

<!-- Instagramfeed JS -->
<!-- <script src="<?php echo URL?>assets/js/plugins/jquery.instagramfeed.min.js"></script> -->

<!-- Ajax Mail JS -->
<script src="<?php echo URL?>assets/js/plugins/ajax.mail.js"></script>

<!-- wow JS -->
<script src="<?php echo URL?>assets/js/plugins/wow.min.js"></script> 

<script src="<?php echo URL?>assets/js/plugins/swiper.min.js"></script> 


<!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load performance and remove plugin js files from avobe) -->

<!--
<script src="assets/js/plugins/plugins.js"></script>
-->

<!-- Main JS -->
<script src="<?php echo URL?>assets/js/main.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- ConfirmJS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="<?php echo URL ?>assets/js/form/toast.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="<?php echo URL ?>assets/js/general/functions.js"></script>

<script src="<?php echo URL?>assets/js/form/form_ajax_submission.js"></script>
<!-- toast.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="<?php echo URL ?>assets/js/form/toast.js"></script>

<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?php echo URL?>assets/js/form/confirmDialogBox.js"></script>

<script src="<?php echo URL?>assets/js/form/waitme/waitMe.min.js"></script>
<script src="<?php echo URL?>assets/js/form/waitme/waitMeCustom.js"></script>

<script src="<?php echo URL ?>assets/js/pages/product_list.js"></script>
<script src="<?php echo URL ?>assets/js/general/addCart.js"></script>
<script src="<?php echo URL ?>assets/js/general/contact.js"></script>
<script src="<?php echo URL ?>assets/js/general/quickView.js"></script>

<!-- <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<!-- jquery (remove this line on webflow (webflow alredy load jquery))-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<!-- waypoints scroll dedection -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js">
</script>

<!-- viemo api -->
<script src="https://player.vimeo.com/api/player.js"></script>

<script>
  // If you want to control the embeds, you’ll need to create a Player object.
  // You can pass either the `<div>` or the `<iframe>` created inside the div.
  /* get video element */
  var viemo_player = new Vimeo.Player('handstick');
  viemo_player.on('play', function() {
    /* For debugging - remove this line from your code";*/
    document.getElementById("videostatus").innerHTML = "play video!";
  });
  viemo_player.on('pause', function() {
    /* For debugging - remove this line from your code";*/
    document.getElementById("videostatus").innerHTML = "pause video!";
  });
  //When the player is ready, set the volume to 0
  viemo_player.ready().then(function() {
    viemo_player.setVolume(0);
  });
  /* #########################################
   WayPoints JS
   https://github.com/imakewebthings/
  ############################################ */
  $('#handstick').waypoint(
    function(direction) {
      if (direction === 'down') {
        /* play video when scroll into view (30% offset) */
        viemo_player.play();
        
        /* For debugging - remove this block from your code";*/
        document.getElementById("scrollStatus").innerHTML = "<b>video in to view</b> | triggerPoint is: Trigger when then the element is:" + this.options.offset + "from top of window (offset) - the triggerPoint is:" + this.triggerPoint + "px" + "| Waypoint element id:" + this.element.id + "<br>" + direction + ' direction';
      } else {
        // document.getElementById("scrollStatus").innerHTML = "out of view scroll top - Debug - remove this block from your code";
        document.getElementById("scrollStatus").innerHTML = "<b>video in to view</b> | triggerPoint is: Trigger when then the element is:" + this.options.offset + "from top of window (offset) - the triggerPoint is:" + this.triggerPoint + "px" + "| Waypoint element id:" + this.element.id + "<br>" + direction + ' direction';
      }
    }, {
      offset: '30%'
    });
</script>