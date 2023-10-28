<!-- <script src="https://unpkg.com/ityped@1.0.3"></script> -->
<script>


$(document).ready(function() {
    if (/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(".call_btn_box").fadeIn(1000);
    }
});


/* link */
function go(url) {
    window.location = url;
}

// Client Area Logos
var clientsLogoArr = [
    "<?php echo URL ?>assets/img/clientLogos/1.png",
    "<?php echo URL ?>assets/img/clientLogos/14.png",
    "<?php echo URL ?>assets/img/clientLogos/3.png",
    "<?php echo URL ?>assets/img/clientLogos/59.png",
    "<?php echo URL ?>assets/img/clientLogos/19.png",
    "<?php echo URL ?>assets/img/clientLogos/5.png",
    "<?php echo URL ?>assets/img/clientLogos/68.png",
    "<?php echo URL ?>assets/img/clientLogos/21.png",
    "<?php echo URL ?>assets/img/clientLogos/6.png",
    "<?php echo URL ?>assets/img/clientLogos/23.png",
    "<?php echo URL ?>assets/img/clientLogos/7.png",
    "<?php echo URL ?>assets/img/clientLogos/71.png",
    "<?php echo URL ?>assets/img/clientLogos/29.png",
    "<?php echo URL ?>assets/img/clientLogos/4.png",
    "<?php echo URL ?>assets/img/clientLogos/25.png",
    "<?php echo URL ?>assets/img/clientLogos/10.png",
    "<?php echo URL ?>assets/img/clientLogos/2.png",
    "<?php echo URL ?>assets/img/clientLogos/11.png",
    "<?php echo URL ?>assets/img/clientLogos/15.png",
    "<?php echo URL ?>assets/img/clientLogos/26.png",
    "<?php echo URL ?>assets/img/clientLogos/17.png",
    "<?php echo URL ?>assets/img/clientLogos/18.png",
    "<?php echo URL ?>assets/img/clientLogos/20.png",
    "<?php echo URL ?>assets/img/clientLogos/13.png",
    "<?php echo URL ?>assets/img/clientLogos/22.png",
    "<?php echo URL ?>assets/img/clientLogos/16.png",
    "<?php echo URL ?>assets/img/clientLogos/24.png",
    "<?php echo URL ?>assets/img/clientLogos/12.png",
    "<?php echo URL ?>assets/img/clientLogos/27.png",
    "<?php echo URL ?>assets/img/clientLogos/8.png",
    "<?php echo URL ?>assets/img/clientLogos/28.png",
    "<?php echo URL ?>assets/img/clientLogos/30.png",
    "<?php echo URL ?>assets/img/clientLogos/31.png",
    "<?php echo URL ?>assets/img/clientLogos/32.png",
    "<?php echo URL ?>assets/img/clientLogos/33.png",
    "<?php echo URL ?>assets/img/clientLogos/34.png",
    "<?php echo URL ?>assets/img/clientLogos/35.png",
    "<?php echo URL ?>assets/img/clientLogos/36.png",
    "<?php echo URL ?>assets/img/clientLogos/9.png",
    "<?php echo URL ?>assets/img/clientLogos/37.png",
    "<?php echo URL ?>assets/img/clientLogos/38.png",
    "<?php echo URL ?>assets/img/clientLogos/39.png",
    "<?php echo URL ?>assets/img/clientLogos/40.png",
    "<?php echo URL ?>assets/img/clientLogos/41.png",
    "<?php echo URL ?>assets/img/clientLogos/42.png",
    "<?php echo URL ?>assets/img/clientLogos/43.png",
    "<?php echo URL ?>assets/img/clientLogos/44.png",
    "<?php echo URL ?>assets/img/clientLogos/45.png",
    "<?php echo URL ?>assets/img/clientLogos/46.png",
    "<?php echo URL ?>assets/img/clientLogos/47.png",
    "<?php echo URL ?>assets/img/clientLogos/48.png",
    "<?php echo URL ?>assets/img/clientLogos/49.png",
    "<?php echo URL ?>assets/img/clientLogos/50.png",
    "<?php echo URL ?>assets/img/clientLogos/51.png",
    "<?php echo URL ?>assets/img/clientLogos/52.png",
    "<?php echo URL ?>assets/img/clientLogos/53.png",
    "<?php echo URL ?>assets/img/clientLogos/54.png",
    "<?php echo URL ?>assets/img/clientLogos/55.png",
    "<?php echo URL ?>assets/img/clientLogos/56.png",
    "<?php echo URL ?>assets/img/clientLogos/57.png",
    "<?php echo URL ?>assets/img/clientLogos/58.png",
    "<?php echo URL ?>assets/img/clientLogos/60.png",
    "<?php echo URL ?>assets/img/clientLogos/61.png",
    "<?php echo URL ?>assets/img/clientLogos/62.png",
    "<?php echo URL ?>assets/img/clientLogos/63.png",
    "<?php echo URL ?>assets/img/clientLogos/64.png",
    "<?php echo URL ?>assets/img/clientLogos/65.png",
    "<?php echo URL ?>assets/img/clientLogos/66.png",
    "<?php echo URL ?>assets/img/clientLogos/67.png",
    "<?php echo URL ?>assets/img/clientLogos/69.png",
    "<?php echo URL ?>assets/img/clientLogos/72.png",
    "<?php echo URL ?>assets/img/clientLogos/73.png",
    "<?php echo URL ?>assets/img/clientLogos/74.png",
    "<?php echo URL ?>assets/img/clientLogos/75.png",
    "<?php echo URL ?>assets/img/clientLogos/76.png",
    "<?php echo URL ?>assets/img/clientLogos/77.png",
    "<?php echo URL ?>assets/img/clientLogos/78.png",
    "<?php echo URL ?>assets/img/clientLogos/79.png",
    "<?php echo URL ?>assets/img/clientLogos/80.png",
    "<?php echo URL ?>assets/img/clientLogos/81.png",
    "<?php echo URL ?>assets/img/clientLogos/82.png",
    "<?php echo URL ?>assets/img/clientLogos/83.png",
    "<?php echo URL ?>assets/img/clientLogos/84.png",
    "<?php echo URL ?>assets/img/clientLogos/85.png",
    "<?php echo URL ?>assets/img/clientLogos/86.png",
    "<?php echo URL ?>assets/img/clientLogos/87.png",
];

var clientsVisibleLogoArr = [];

let clientsLogosBox = $('#clients_logos-box');
let singleLogoBox = clientsLogosBox.find('.single-logo');
let singleBoxClone = singleLogoBox.clone();


// function to switch array of elements
function interchangeArrayValues(allLogos, visibleLogos) {

    visibleLogos.push(allLogos[0]);
    allLogos.shift();
    // delete allLogos[i];

    return {
        'clientsLogoArr': allLogos,
        'clientsVisibleLogoArr': visibleLogos
    };

} //interchangeArrayValues

function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }

    return array;
}


// Initialization
clientsLogosBox.empty();
visibleLogoCounts = 12;

var replaceOrder = [];


for (i = 0; i < visibleLogoCounts; i++) {

    let tempClonc = singleBoxClone.clone();
   
    tempClonc.find('img').attr('src', clientsLogoArr[0]);
    // console.log(tempClonc)
    clientsLogosBox.append(tempClonc).hide().fadeIn(500);

    // interchangeArrayValues
    interChagedRes = interchangeArrayValues(clientsLogoArr, clientsVisibleLogoArr);
    clientsVisibleLogoArr = interChagedRes['clientsVisibleLogoArr'];
    clientsLogoArr = interChagedRes['clientsLogoArr'];

    // Put number of logos
    replaceOrder.push(i);

}

// Shuffle the ordered array to randomize pick
replaceOrder = shuffleArray(replaceOrder);

function replaceClientLogo() {

    replaceLocNo = replaceOrder[0];
    clientsLogoArr.push(clientsVisibleLogoArr[replaceLocNo])
    clientsVisibleLogoArr[replaceLocNo] = clientsLogoArr[0];

    let tempClonc = singleBoxClone.clone();
    tempClonc.find('img').attr('src', clientsLogoArr[0]);

    clientsLogosBox.find('.single-logo').eq(replaceLocNo).fadeOut(1000, function() {
        $(this).replaceWith(function() {
            return tempClonc.hide().fadeIn(1000);
        });
    });

    clientsLogoArr.shift();
    replaceOrder.shift();
    replaceOrder.push(replaceLocNo);

} //replaceClientLogo

function changeImage() {
    let countReplaceLogos = Math.floor(Math.random() * 2) + 1;

    while (countReplaceLogos > 0) {
        replaceClientLogo();
        countReplaceLogos--;
    }

}

setInterval(() => {
    changeImage();
}, 2000);

// activeate Menu
$('#home').addClass('active');


$(document).ready(() => {
    $('.grid-image_slider1').slick({
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1000,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,

    });
});
</script>