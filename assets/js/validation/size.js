// validate signup form on keyup and submit
$("#size-request-form").validate({
    rules: {
        contact_no :{
            required: true,
            number:true,
            minlength: 10
        },
        email:{
            email:true
        }
    },
    messages: {
        contact_no :{
            required : 'Enter your phone number',
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