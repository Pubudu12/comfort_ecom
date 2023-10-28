// Create Category
// Enable Sub Category

function loadSubCategoryFields(level, parentId){

    var subCatFields = $('#sub_categories_fields');

    var fetchURL = ROOT_URL+'category/ajax/controller/viewCategoryController.php';
    $.ajax({
        type: 'POST',
        url: fetchURL,
        data: {
            'level': level,
            'parentId' : parentId,
            'view_cat_level' : 'yes',
        },
        dataType: 'json',
        success:function(res){

            if(res.show == 1){

                subCatFields.append(res.combo);
                $('.category_select2').select2();
            }

        },
        error:function(err){
            console.error(err);
        }
    });

} //loadSubCategoryFields()


function loadSubCatCheck(e){

    var parentId = $(e).val();
    var level = $(e).data('level')+1;

    var singleParentComboBox = $(e).parents('.combo_box_single');

    singleParentComboBox.nextAll().remove();

    loadSubCategoryFields(level, parentId);

} //loadSubCatCheck

function subCategoryComboBox(){

    var subCatFields = document.getElementById('sub_categories_fields');
    var subCatEnable = document.getElementById('sub_category_enable');

    if (subCatEnable.checked) {
        subCatFields.innerHTML = '';
        loadSubCategoryFields(1, 0);
      } else {
        subCatFields.innerHTML = '';
      }

} //subCategoryComboBox

// Image Uploads
function uploadImage(imageURL) {
    console.log(imageURL)
    $(imageURL).insertBefore('.uploadBox')

} // function end 

$("#pack_img_upload").on('change', function(e){

    let form = $("#package_images_form");
    var formData = new FormData(form[0]);

    showDomLoading(form)
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
                
                uploadImage(response.imgBox);

            }else{

                notifyMessage(response['message'],"Failed");
            }

            hideDomLoading(form)

        }, // success
        error:function(err){
            console.log('err');
            console.log(err);
            notifyMessage('Please try again later',"Failed");
            // alert(err)
            hideDomLoading(form)
        }
    }); // ajax end 

});

function deleteImage(e){

    let imageId = $(e).parents('.fix-box').data('id');
    let deleteThis = $(e).parents('.img_single_box');

    showDomLoading(deleteThis)
    // Ajax Start
    $.ajax({
        type: 'POST',
        url: ROOT_URL+'category/ajax/controller/deleteCategoryController.php',
        data: {
            'imageId' : imageId,
            'deletePackThumb' : 'yes'
        },
        dataType: 'json',
        success: function (response) {
        
            if(response['result'] == 1){

                hideDomLoading(deleteThis)
                deleteThis.remove();

            }else{

                notifyMessage(response['message'],"Failed");
                deleteThis.loading('stop');
            }


        }, // success
        error:function(err){
            console.error(err);
            notifyMessage('Please try again later',"Failed");
            
            hideDomLoading(deleteThis)
        }
    }); // ajax end 

};