grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
    grecaptcha.execute('6LeS7XgeAAAAAMDTLHBZ6CTo6WE7Tb9pZIjC913q', {action: 'create_comment'}).then(function(token) {
        // add token to form
        $('#contactForm').prepend('<input type="hidden" name="token" value="'+token+'">');
    });
});

$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value);
    }, "type the correct answer -_-");
		
		$('#success, #error').hide();

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: false,
                    minlength: 2
                }
            },
            messages: {
                name: {
                    required: "come on, you have a name don't you?",
                    minlength: "your name must consist of at least 2 characters"
                },
                email: {
                    required: "Please provide your email address."
                },
                message: {
                    required: "um...yea, you have to write something to send this form.",
                    minlength: "thats all? really?"
                }
            },
            submitHandler: function(form) {

                let formSubmitted = $(form);

                $.ajax({
                    type: formSubmitted.attr('method'),
                    data: formSubmitted.serialize(),
                    url: formSubmitted.attr('action'),
                    dataType: 'json',
                    success: function(res) {
                    
                        // console.log(res);

                        if(res.result == 1){
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo( "slow", 0.90, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor','default');
                                $('#success').fadeIn();
                            });
                        }else{
                        
                            $('#contactForm').fadeTo( "slow", 0.15, function() {
                                $('#error').fadeIn();
                            });
                            
                        }

                        
                    },
                    error: function(err) {
                        // console.log(err);
                        $('#contactForm').fadeTo( "slow", 0.15, function() {
                            $('#error').fadeIn();
                        });
                    }
                })
            }
        })
		
    })
        
 })(jQuery)
})