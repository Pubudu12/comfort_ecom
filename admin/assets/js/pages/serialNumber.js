$(document).ready(function(){
    $('#upload_csv').on('submit', function(event){
     
     event.preventDefault();
     url = ROOT_URL+'serialNumber/ajax/controller/uploadSerialNumbersController.php';
     $.ajax({
      url: url,
      method:"POST",
      data: new FormData(this),
      dataType:'json',
      contentType:false,
      cache:false,
      processData:false,
      success:function(data){
          console.log(data)
        $('#tableData').removeClass('hide')
        $('#csv_data_table').html(data.data.existingTble);
        $('#serialArray').val(data.serialized)
        // $('#upload_csv')[0].reset();
      },error:function(err) {
          console.log(err)
      }
   })
    });
});
   
$('#upload_data').on('click', function(event){
    // newFile = new FormData(this);
     event.preventDefault();
     url = ROOT_URL+'serialNumber/ajax/controller/uploadSerialNumbersController.php';
    //  console.log(newFile)
  
    serialArray = $('#serialArray').val()
     $.ajax({
      url: url,
      method: "POST",
      dataType:'json',
      data:{
          'upload_serial_number_list':'yes',
          'serial_list':serialArray
      },
      success:function(data){
        console.log(data)
        if (data.result == 1) {
          showSuccessToast(data.message);
        } else {
          showDangerToast(data.message)
        }
      },
      error:function(err){
        console.log('err')
          console.log(err)
      }
     })
});