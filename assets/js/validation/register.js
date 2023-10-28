// validate signup form on keyup and submit
$("#register_form").validate({
    rules: {

        register_form_name : {
            required: true,
        },
        register_form_email : {
            required: true,
            email: true
        },
        register_form_phone : {
            required: true,
            minlength: 10
        },
        register_form_password : {
            required: true,
            minlength: 8
        },
        register_form_repassword : {
            required: true,
        },
    },
    messages: {

        register_form_name : {
            required: 'Please provide your name',
        },
        register_form_email : {
            required: 'Please provide your email address',
        },
        register_form_phone : {
            required: 'Please provide your phone number',
        },
        register_form_password : {
            required: 'Please enter your password',
        },
        register_form_repassword : {
            required: 'Please re-enter your password',
        }
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
