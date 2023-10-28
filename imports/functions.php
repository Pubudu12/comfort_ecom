    <?php

    $payment_method_arr = array(
        ['code' => 'cash', 'name' => 'Cash'],
        ['code' => 'card', 'name' => 'Card'],
        ['code' => 'cheque', 'name' => 'Cheque'],
        ['code' => 'dbt', 'name' => 'Direct Bank Transfer'],
    );

    function checkboxChecked($data, $comData)
    {
        if (trim($data) == $comData) {
            return "checked";
        }
    } // checkboxChecked End


    function checkboxCheckedActive($data)
    {
        if (trim($data, " ") == 1) {
            return "active";
        }
    } // checkboxChecked End


    function comboboxSelected($data1, $data2)
    {

        if (trim($data1) == trim($data2)) {
            return "selected";
        }
    } // comboboxSelected End

    function comboboxSelectedIfOne($data)
    {
        if (trim($data) == 1) {
            return "selected";
        }
    } // comboboxSelected End

    function comboboxDataArray($data, $array)
    {

        if (in_array(trim($data, " "), $array)) {
            return "selected";
        }
    } // comboboxDataArray end

    function hideNotNumber($data)
    {
        $number = trim($data);
        if ($number == "" || empty($number) || $number == "null" || $number == 0) {
            return "display:none";
        }
    } // hideNotNumber End

    function hideNotEmail($data)
    {
        $email = trim($data);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "display:none";
        }
    } // hideNotEmail End

    function hideNotText($data)
    {
        $text = trim($data);

        if (empty($text)) {
            return "display:none !important";
        }
    } // hideNotText End

    function hideEmptyArray($array)
    {

        if (count($array) == 0) {
            return "display:none !important";
        } // if loop end

    } // hideEmptyArray End

    function hideRowZero($rows)
    {
        if ($rows == 0) {
            return "display:none !important";
        } // if loop end 
    }  // hideRowZero END 

    function checkEmptyString($data)
    {
        $value = trim($data);
        if ($value != "null" && !empty($value) && $value != "") {
            return "";
        } else {
            return "hide";
        } // If Data IS NULL Chekc If LOOP END
    } // Check Empty String Function END

    function checkExperience($data)
    {

        $data = trim($data);

        if ($data == 0) {
            return "Fresher";
        } else if ($data == 1 && is_numeric($data)) {
            return $data . " Year";
        } else if ($data > 1 && is_numeric($data)) {
            return $data . " Years";
        } else {
            return $data;
        }
    } // checkExperience End

    function hideIfZero($data)
    {
        if (trim($data) <= 0) {
            return "display:none !important";
        }
    } //hideIfZero

    function doactive($data1, $data2)
    {
        if (trim($data1) == trim($data2)) {
            return "active";
        }
    }


    function hideNotMatched($data1, $data2){
        if (trim($data1) == trim($data2)) {
            return "mustHide";
        }
    } //hideNotMatched

    function hideIfMatched($data1, $data2){
        if (trim($data1) == trim($data2)) {
            return "mustHide";
        }
    } //hideNotMatched

    function zeroreplace($data, $replaceWith){

        $return = $replaceWith;
        if($data != 0){
            $return = number_format($data, 2);
        }

        return $return;

    } //zeroreplace

    
    function getsub($first,$last){
        switch ($last){
            case 1: 
                echo $first.$last."<sup>st</sup>";
                break;
            case 2: 
                echo $first.$last."<sup>nd</sup>";
                break;
            case 3: 
                echo $first.$last."<sup>rd</sup>";
                break;
            default :
                echo $first.$last."<sup>th</sup>";
                break;
        } // switch statement END
    }

    function datesuperscript($date){
        $f_date = substr($date,0,1);
        $l_date = substr($date,-1);
        
        if($f_date == 1){ // if first letter of the date is 1 then this loop
            return $date."<sup>th</sup>";
        }else{ // if first letter of the date is not 1 then executive here
            return getsub($f_date,$l_date);
        } // first letter of the date check if loop end
        
    }


    /*
    function isEmail(email){

    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);

    } */ // is email close

    function textValidation($data, $connection)
    {

        if (is_array($data)) {

            foreach ($data as $key => $value) {
                $data[$key] = mysqli_real_escape_string($connection, $value);
            } // foreach end

        } else {
            $data = mysqli_real_escape_string($connection, $data);
        }

        return $data;
    }



    
    // Now this better Function
    function get_time_ago( $time )
    {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return ' 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }


    // Time Conversation Functions
    function time_Ago($time) { 

        $date1 = new DateTime($time);
        $date2 = new DateTime('now');
        
        $difference = $date1->diff($date2);
    
        $timeAgoDisplay = '';
        
        // Time difference in seconds 
        $sec	 = $difference->format("%S");
        
        // Convert time difference in minutes 
        $min	 = $difference->format("%I");
        
        // Convert time difference in hours 
        $hrs	 = $difference->format("%H");
        
        // Convert time difference in days 
        $days	 = $difference->format("%d");
        
        // Convert time difference in weeks 
        $weeks	 = $difference->format("%d");
        
        // Convert time difference in months 
        $mnths	 = $difference->format("%m");
        
        // Convert time difference in years 
        $yrs	 = $difference->format("%y");
        
        // Check for seconds 
        if($sec <= 60) { 
            $timeAgoDisplay =  "$sec seconds ago"; 
        }
        
        // Check for minutes 
        if( ($min <= 60) && ($min != 0) ) { 
            if($min==1) { 
                $timeAgoDisplay = "one minute ago"; 
            } 
            else { 
                $timeAgoDisplay = "$min minutes ago"; 
            } 
        } 
        
        // Check for hours 
        if( ($hrs <= 24) && ($hrs != 0) ) { 
            if($hrs == 1) { 
                $timeAgoDisplay = "an hour ago"; 
            } 
            else { 
                $timeAgoDisplay = "$hrs hours ago"; 
            } 
        } 
        
        // Check for days 
        if( ($days <= 7) && ($days != 0) ) { 
            if($days == 1) { 
                $timeAgoDisplay = "Yesterday"; 
            } 
            else { 
                $timeAgoDisplay = "$days days ago"; 
            }
        } 
        
        // Check for weeks 
        // else if($weeks <= 4.3) { 
        // 	if($weeks == 1) { 
        // 		$timeAgoDisplay = "a week ago"; 
        // 	} 
        // 	else { 
        // 		$timeAgoDisplay = "$weeks weeks ago"; 
        // 	} 
        // } 
        
        // Check for months 
        if( ($mnths <= 12) && ($mnths != 0) ) { 
            if($mnths == 1) { 
                $timeAgoDisplay = "a month ago"; 
            } 
            else { 
                $timeAgoDisplay = "$mnths months ago"; 
            } 
        }
        
        // Check for years 
        if( $yrs > 1   ) { 
    
            if($yrs == 1){
                $timeAgoDisplay = "one year ago"; 
    
                }else{
                    
                    $timeAgoDisplay = "$yrs years ago";
            }
    
        } 
        
        return $timeAgoDisplay;
    }


    function balance($debit,$credit,$type){
        $balance= 0;
        if($type == "dr"){
            $balance = $debit-$credit;
        }else if($type == "cr"){
            $balance = $credit-$debit;
        }
        return $balance;
    }

    function NumberValidation($localhost,$number){
        $number = mysqli_real_escape_string($localhost,trim($number));
        return $number;
    }

    function checkUserAccess(){

        $result = 0;
        $message = "guest";
    
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) ){
            if($_SESSION['user_type'] == "std"){
                $user_id = $_SESSION['user_id'];
                $user_type = "std";
                $result = 1;
                $message = "std";
            } // check user tye std if end 
            if($_SESSION['user_type'] == "dealer"){
                $user_id = $_SESSION['user_id'];
                $user_type = "dealer";
                $result = 2;
                $message = "dealer";
            } // check user tye std if end 
            
        } // check session if loop end 
    
        return array("access"=>$result,"user_type"=>$message);
    
    } // checkUserAccess
    

    ?>