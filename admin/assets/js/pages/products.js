
// Product Creation Page
$(document).on('change','#category',function(e){
    var categoryId = $(this).val();
    
    var fetchURL = ROOT_URL+'products/ajax/controller/viewProductController.php';

    $.ajax({
        type: 'POST',
        url: fetchURL,
        data: {category : categoryId},
        dataType: 'json',
        success:function(ret){
            $("#sub_categories").html(ret['result']);
        }, 
        error:function(err){
            console.error(err);
        }
        
    });
})

function loadSubCategoryFields(level, parentId){

    var subCatFields = $('#sub_categories_fields');

    var fetchURL = ROOT_URL+'category/ajax/controller/viewCategoryController.php';
    $.ajax({
        type: 'POST',
        url: fetchURL,
        data: {
            'level': level,
            'parentId' : parentId,
            'view_cat_level_for_products' : 'yes',
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

function loadSubCatForPro(e){
    
    $(e).parents('.category_box').nextAll('.category_box').remove();

    var parentId = $(e).val();
    var level = $(e).data('level')+1;
    
    var singleParentComboBox = $(e).parents('.combo_box_single');

    singleParentComboBox.nextAll().remove();

    loadSubCategoryFields(level, parentId);
}

// Image Upload
// Image Uploads
function uploadImage(imageURL) {

    $(imageURL).insertBefore('.uploadBox')

} // function end 


function changeImageType(id,e){    
    
    img_id = id;

    var fetchURL = ROOT_URL+'products/ajax/controller/updateProductController.php';
    
    $.ajax({
        type: 'POST',
        url: fetchURL,
        data: {
            'imgType': e.value,
            'image_id' : img_id,
            'product_image_type' : 'yes',
        },
        dataType: 'json',
        success:function(res){
            if(res.result == 1){
                showSuccessToast(res['message']);
                refresh();
            }else{
                showDangerToast(res['message'])
            }
            console.log(res)
        },
        error:function(err){
            console.error('err');
            console.error(err);
        }
    });    
}//changeImageType

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
        url: ROOT_URL+'products/ajax/controller/deleteProductController.php',
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

// Edit prodcts Page
function enableChangeCategory(){
    // alert('called')
    var enableCatFields = document.getElementById('enableCategoryEdit');

    var catEditField = document.getElementById('category_edit_field');

    if (enableCatFields.checked) {
        
        catEditField.style.display = 'block';

    } else {
        catEditField.style.display = 'none';
    }
    
}

function refresh() {
    setTimeout(function () {
        location.reload()
    }, 2000);
}

function deleteSerialFromProduct(pro_serial_id) {
    var form = $(this).parents('form');
    product_id = $('#product_id').val();

    $.ajax({
        type: 'POST',
        url: ROOT_URL+'products/ajax/controller/createProductController.php',
        data: {
            'product_id':product_id,
            'pro_serial_id' : pro_serial_id,
            'delete_serial_numbers' : 'yes'
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            showSuccessToast(response['message']);
            refresh();
        }, // success
        error:function(err){
            showDangerToast('Error')
            console.error(err);
        }
    }); // ajax end 
}

function deleteDealerFromProduct(pro_dealer_id) {
    product_id = $('#product_id').val();

    $.ajax({
        type: 'POST',
        url: ROOT_URL+'products/ajax/controller/createProductController.php',
        data: {
            'product_id':product_id,
            'pro_dealer_id' : pro_dealer_id,
            'delete_dealer' : 'yes'
        },
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            showSuccessToast(response['message']);
            refresh();
        }, // success
        error:function(err){
            showDangerToast('Error')
            console.error(err);
        }
    }); // ajax end 
}