
// Image Uploads
function uploadImage(imageURL) {

    $(imageURL).insertBefore('.uploadBox')

} // function end 


$("#pack_img_upload").on('change', function(e){

    let form = $("#package_images_form");
    var formData = new FormData(form[0]);

    showDomLoading(form);
    // Ajax Start
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
        
            console.log(response);

            if(response['result'] == 1){

                uploadImage(response.image_box);
                $("#thumb_upload_box").hide(100);

            }else{

                notifyMessage(response['message'],"Failed");
            }

            hideDomLoading(form);

        }, // success
        error:function(err){
            console.log('err');
            console.log(err);
            notifyMessage('Please try again later',"Failed");
            // alert(err)
            hideDomLoading(form);
        }
    }); // ajax end 

});


function uploadCoverImage(imageContainer) {
    
    let imgParentBox = $(".cover_img_box");
    if(imgParentBox.hasClass('img_exist')){

    }else{
        imgParentBox.addClass('img_exist');
    }
    
    imgParentBox.find('.cover_img').remove();
    imgParentBox.append(imageContainer);

} //uploadCoverImage

// Upload Cover Img
$("#cover_img_upload").on('change', function(e){


    let form = $("#cover_images_form");
    var formData = new FormData(form[0]);

    showDomLoading(form);
    // Ajax Start
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
        

            if(response['result'] == 1){

                uploadCoverImage(response.image_box);

            }else{

                notifyMessage(response['message'],"Failed");
            }

            hideDomLoading(form);

        }, // success
        error:function(err){
            console.log('err');
            console.log(err);
            notifyMessage('Please try again later',"Failed");
            // alert(err)
            hideDomLoading(form);
        }
    }); // ajax end 

});


function deleteImage(e){

    let imageId = $(e).parents('.fix-box').data('id');
    
    let deleteThis = $(e).parents('.img_single_box');

    showDomLoading(deleteThis);
    // Ajax Start
    $.ajax({
        type: 'POST',
        url: 'ajax/controller/deletePostController.php',
        data: {
            'post_id' : imageId,
            'deletePackThumb' : 'yes'
        },
        dataType: 'json',
        success: function (response) {
        
            if(response['result'] == 1){

                hideDomLoading(deleteThis);
                deleteThis.remove();

                $("#thumb_upload_box").show(200);

            }else{

                notifyMessage(response['message'],"Failed");
                hideDomLoading(deleteThis);
            }


        }, // success
        error:function(err){
            console.log('err');
            console.log(err);
            notifyMessage('Please try again later',"Failed");
            
            hideDomLoading(deleteThis);
        }
    }); // ajax end 

};

function fetchCategories() {
    post_type = $('#post_type').val();
    category_list = $('#category_list');

    // Ajax Start
    $.ajax({
        type: 'POST',
        url: ROOT_URL+'blog/posts/ajax/controller/viewPostController.php',
        data: {
            'post_type' : post_type,
            'fetchCategories' : 'yes'
        },
        dataType: 'json',
        success: function (response) {
            category_list.html(response);
        }, // success
        error:function(err){
            console.log('err');
            console.log(err);
        }
    }); // ajax end 
}