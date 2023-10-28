// validate signup form on keyup and submit
$("#login_form").validate({
    rules: {

        login_form_email :{
            required : true,
            email:true
        },
        login_form_password :{
            required : true,
        },
    },
    messages: {

        login_form_email :{
            required : 'Enter your email',
        },
        login_form_password :{
            required : 'Enter your password',
        },

    },
    errorPlacement: function(label, element) {
        label.addClass('mt-2 text-danger');
        label.insertAfter(element);
    },
    highlight: function(element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
    },
    submitHandler: function (form) { // for demo
        // alert('valid form submitted'); // for demo
        // return false; // for demo
    }
});