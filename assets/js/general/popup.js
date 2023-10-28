/*
	@author: Ilyas karim <ilyas.datoo@gmail.com>
	@date: 5/may/2016

*/
(function ($) {
	setInterval(function(){
		$(".navbar-brand").html($(document).width());
	},10)
	$.fn.jPopup = function (options) {
		var settings = $.extend({
			popupParent : "gee-popup",
			scrollTopPx : 100,
			popupCloseButton : ".popup-close-button",
			heading : "heading - You can change",
			paragraph : "You can change paragraph from options. You can also change the input into your own template",
			userContent : '<div class="input"> <input class="form-control" type="text" placeholder="Your Email" > </div>',
			image : "<img src=''>",
			buttonText1 : 'Click me',
			buttonText2 : 'Contact Us',
			buttonClass : "btn btn-info btn-block btn-lg",
			// openPopup : "asd",
			initThrough : function () {
				$(window).on('scroll', function(event) {
					var scrollValue = $(window).scrollTop();
					if (scrollValue == settings.scrollTopPx || scrollValue > settings.scrollTopPx) {
						// call the popup
						if (hasPopuped == false) {
							
							$.ajax({
								type: 'post',
								url: ROOT_URL+'/ajax/controller/sessionController.php',
								data: { 'check_cookie' : 'yes' },
								dataType: 'json',
								success:function(res){
									if(res.result == 0){
										$.fn.jPopup.openPopup();
									}
								}, // success
								error:function(err){
									//Error
									console.log(err);
								}
							}); // Ajax end
						}
					}
				});
			},
			openPopup : function () {
				$("html").addClass('active-poup');
			}
		}, options);
		var hasPopuped = false;
		var scrollValue = $(window).scrollTop();
		settings.initThrough();
		$(".gee-popup .popup-title").html(settings.heading);
		$(".gee-popup .paragraph").html(settings.paragraph);
		$(".gee-popup .user-content").html(settings.userContent);
		$(".gee-popup .pop-img").html(settings.image);
		$(".gee-popup .btn1").html(settings.buttonText1);
		$(".gee-popup .btn2").html(settings.buttonText2);
		$(".gee-popup .btn1").addClass(settings.buttonClass);
		$(".gee-popup .btn2").addClass(settings.buttonClass);
		$(".popup-close-button").click(function() {
			$('html').toggleClass('active-poup');
			hasPopuped = true;
		});
	}
	$.fn.jPopup.openPopup = function () {
		$("html").addClass('active-poup');
	}
}(jQuery))
