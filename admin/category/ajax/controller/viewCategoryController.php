<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['view_cat_level'])){

        $result = 0;
        $error = 0;
        $message = "Failed to load sub categories";
        $redirectURL = null;
        $show = 0;

        $subCatArray = array();

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'level' => 'required|numeric',
            'parentId' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'level' => 'trim|sanitize_numbers',
            'parentId' => 'trim|sanitize_numbers',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $level = $validated_data['level'];
            $parent_id = $validated_data['parentId'];

            $query = "SELECT * FROM `categories` WHERE `level` = '$level' ";

            if( ($parent_id >= 0) && ($level < CAT_MAX_LEVEL ) ){
                $query .= " AND `parent` = '$parent_id' ";
            }
            $select_category = mysqli_query($localhost, $query); 
            while($fetch_categories = mysqli_fetch_array($select_category)){ 
    
                array_push($subCatArray, array(
                    'id'=>$fetch_categories['id'],
                    'name'=>$fetch_categories['name'],
                ));
    
            }// while

        }

        $sub_category_option = '<option value="0" disabled selected>Select Category</option>';
        foreach ($subCatArray as $key => $value) {
            $sub_category_option .= '<option value="'.$value['id'].'"> '.$value['name'] .'</option>';
        } // Foreach

        $comboTemp = file_get_contents(ROOT_PATH.'category/container/subCategoryCombo.html');
        $comboTemp = str_replace("{{ OPTIONS }}", $sub_category_option, $comboTemp);
        $comboTemp = str_replace("{{ ONCHANGE }}", 'loadSubCatCheck(this)', $comboTemp);
        $comboTemp = str_replace("{{ DATA_LEVEL }}", $level, $comboTemp);
        

        if( (count($subCatArray) > 0) && ($level < CAT_MAX_LEVEL) ){
            $show = 1;
        }

        echo json_encode(array( 'show'=>$show, "combo"=>$comboTemp));


    }// isset

    if(isset($_POST['view_cat_level_for_products'])){

        $result = 0;
        $error = 0;
        $message = "Failed to load sub categories";
        $redirectURL = null;
        $show = 0;

        $subCatArray = array();

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'level' => 'required|numeric',
            'parentId' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'level' => 'trim|sanitize_numbers',
            'parentId' => 'trim|sanitize_numbers',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $level = $validated_data['level'];
            $parent_id = $validated_data['parentId'];

            $query = "SELECT * FROM `categories` WHERE `level` = '$level' ";

            if( ($parent_id >= 0) && ($level <= CAT_MAX_LEVEL ) ){
                $query .= " AND `parent` = '$parent_id' ";
            }
            $select_category = mysqli_query($localhost, $query); 
            while($fetch_categories = mysqli_fetch_array($select_category)){ 
    
                array_push($subCatArray, array(
                    'id'=>$fetch_categories['id'],
                    'name'=>$fetch_categories['name'],
                ));
    
            }// while

        }

        $sub_category_option = '<option value="0" disabled selected>Select Category</option>';
        foreach ($subCatArray as $key => $value) {
            $sub_category_option .= '<option value="'.$value['id'].'"> '.$value['name'] .'</option>';
        } // Foreach

        $comboTemp = file_get_contents(ROOT_PATH.'category/container/subCategoryComboForProducts.html');
        $comboTemp = str_replace("{{ OPTIONS }}", $sub_category_option, $comboTemp);
        $comboTemp = str_replace("{{ DATA_LEVEL }}", $level, $comboTemp);
        

        if( (count($subCatArray) > 0) && ($level <= CAT_MAX_LEVEL) ){
            $show = 1;
        }

        echo json_encode(array( 'show'=>$show, "combo"=>$comboTemp));


    } //view_cat_level_for_products

} // Post End 