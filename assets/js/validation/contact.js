// validate signup form on keyup and submit
$("#form-validate").validate({
    rules: {

        email :{
            required : true,
            email:true
        },
        phone : {
            required: true,
            minlength: 10
        },
    },
    messages: {

        email :{
            required : 'Enter your email',
        },
        phone :{
            required : 'Please provide your phone number',
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
        console.log('called form success')
        alert('valid form submitted'); // for demo
        // return false; // for demo
    }
});