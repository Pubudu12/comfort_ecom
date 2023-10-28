<?php 
function checkboxChecked($data){
  if(trim($data," ") == 1){
    return "checked";
  }
} // checkboxChecked End

function checkboxCheckedActive($data){
  if(trim($data," ") == 1){
    return "active";
  }
} // checkboxChecked End

function checkboxCheckedCompare($data1, $data2){
  if(trim($data1) == trim($data2) ){
    return "checked";
  }
} // checkboxChecked End

function checkboxDataArray($data,$array){

  if( in_array(trim($data," "),$array) ){
    return "checked";
  }

} // comboboxDataArray end


function comboboxSelected($data1,$data2){

  if(trim($data1) == trim($data2) ){
    return "selected";
  }
} // comboboxSelected End

function comboboxDataArray($data,$array){

  if( in_array(trim($data," "),$array) ){
    return "selected";
  }

} // comboboxDataArray end

function hideNotNumber($data){
  $number = trim($data);
  if( $number == "" || empty($number) || $number == "null" || $number == 0 ){
    return "display:none";
  }
} // hideNotNumber End

function hideNotEmail($data){
  $email = trim($data);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "display:none";
  }

} // hideNotEmail End

function hideNotText($data){
  $text = trim($data);

  if ( empty($text) ) {
    return "display:none !important";
  }

} // hideNotText End

function hideEmptyArray($array){

  if( count($array) == 0 ){
    return "hide";
  } // if loop end

} // hideEmptyArray End

function hideRowZero($rows){
  if($rows == 0){
    return "display:none !important";
  } // if loop end 
}  // hideRowZero END 

function checkEmptyString($data){
  $value = trim($data);
  if($value != "null" && !empty($value) && $value != "" ){
      return "";
  }else{
      return "hide";
  } // If Data IS NULL Chekc If LOOP END
} // Check Empty String Function END

function checkExperience($data){
  
  $data = trim($data);

  if($data == 0){
    return "Fresher";

  }else if($data == 1 && is_numeric($data)){
    return $data." Year";

  }else if($data > 1 && is_numeric($data) ){
    return $data." Years";

  }else{
    return $data;
  }
  
} // checkExperience End

function hideIfZero($data){
  if ( trim( $data ) <= 0  ) {
    return "hide";
  }
} //hideIfZero

function doactive($data1, $data2){
  if(trim($data1) == trim($data2) ){
    return "active";
  }
}

/*
function isEmail(email){

  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);

} */// is email close

function textValidation($data,$localhostnection){
  
  if(is_array($data)){

    foreach($data AS $key => $value){
        $data[$key] = mysqli_real_escape_string($localhostnection,$value);
    }// foreach end

  }else{
      $data = mysqli_real_escape_string($localhostnection,$data);
  }

  return $data;
}


// Upload image functions
function getExtension($str) {
  $i = strrpos($str,".");
  if (!$i) {
    return "";
  }
  $l = strlen($str) - $i;
  $ext = substr($str,$i+1,$l);
  return $ext;
}

//function for compress image
  function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth,$path_to,$quality) {

    if($ext=="jpg" || $ext=="jpeg" ) {
      $src = imagecreatefromjpeg($uploadedfile);
    } else if($ext=="png") {
      $src = imagecreatefrompng($uploadedfile);
    } else if($ext=="gif") {
      $src = imagecreatefromgif($uploadedfile);
    } else {
      $src = imagecreatefrombmp($uploadedfile);
    }

    list($width,$height)=getimagesize($uploadedfile);
    $newheight=($height/$width)*$newwidth;
    $tmp=imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
    $filename = $path_to.$actual_image_name; //PixelSize_TimeStamp.jpg
    imagejpeg($tmp,$filename,$quality);
    $compress_image = $path.$filename;
    copy($filename,$compress_image);
    imagedestroy($tmp);
    return $filename;
  }

?>