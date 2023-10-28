<?php 
class SerialNumberClass {
    public $localhost, $dbOpertionsObj;

    function __construct($localhost, $dbOpertionsObj)
    {
        $this->localhost = $localhost;
        $this->dbOpertionsObj = $dbOpertionsObj;
    }

    public function validateArray($csvFileDataArray){
        // print_r($csvFileDataArray);
        $existingSerialArray = array();
        $select = mysqli_query($this->localhost, "SELECT `id`,`serial_number` FROM `serial_numbers` ");
        while($fetch = mysqli_fetch_array($select)){
            array_push($existingSerialArray,array(
                'id'=>$fetch['id'],
                'serial'=>$fetch['serial_number'],
            ));
        }
        $option = '';
        $serchArray = array();
        foreach ($existingSerialArray as $existArrKey => $singleExistValue) {
            foreach ($csvFileDataArray as $csvFileKey => $singleSerial) {
                
                if ($singleSerial[0] == $singleExistValue['serial']) {
                    array_push($serchArray,$singleExistValue['serial']);
                    $option .='<tr>
                                    <td>  </td>
                                    <td> '.$singleExistValue['serial'].' </td>
                                    <td> This serial number alerady exists. </td>
                                </tr>';
                    break;
                }
            }
        }
        $option2 = '';
        $addArray = array();
        foreach ($csvFileDataArray as $key => $singleSerial) {
            
            if (! in_array($singleSerial[0],$serchArray)) {
                array_push($addArray,array(
                    'name'=>$singleSerial[1],
                    'serial_number'=>$singleSerial[0]
                ));
                $option .='<tr>
                                <td> '.$singleSerial[1].' </td>
                                <td> '.$singleSerial[0].' </td>
                                <td> New Serial Number </td>
                            </tr>';
            }
        }
        return array('existing_array'=>$serchArray,'new_serial_numbers'=>$addArray,'existingTble'=>$option);
    }
}

$serialNumberOBJ = new SerialNumberClass($localhost, $dbOpertionsObj);
?>