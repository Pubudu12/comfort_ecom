<?php 

class DBOperationsClass{

    protected $localhost;

    public function __construct($host){
        $this->localhost = $host;
    }

    private function executeQuery($query, $operation, $bindParam = null){
        
        $resultArr = array();
        $result = 0;

        switch ($operation) {
            case 'insert':
                    $execute = $this -> localhost -> prepare($query);
                    if (
                        $execute &&
                        // $execute -> bind_param() &&
                        $execute -> execute()
                    ) {
                        // new user added
                        $resultArr['id'] = mysqli_insert_id($this->localhost);
                        $result = 1;
                    }else{

                        $error = mysqli_error($this->localhost);
                        $resultArr['error'] = array('query'=>$query, 'error'=>$error);

                    }

                break;

            case 'update':
                    

                    $execute = $this -> localhost -> prepare($query);
                    if (
                        $execute &&
                        // $execute -> bind_param() &&
                        $execute -> execute()
                    ) {
                        // 
                        $result = 1;
                    }else{

                        $error = mysqli_error($this->localhost);
                        $resultArr['error'] = array('query'=>$query, 'error'=>$error);

                    }

                break;

            case 'delete':
                    

                    $execute = $this -> localhost -> prepare($query);
                    if (
                        $execute &&
                        // $execute -> bind_param() &&
                        $execute -> execute()
                    ) {
                        // Deleted Successfully
                        $result = 1;
                    }else{

                        $error = mysqli_error($this->localhost);
                        $resultArr['error'] = array('query'=>$query, 'error'=>$error);

                    }

                break;

            case 'count':
                    $select  = mysqli_query($this->localhost, $query);
                    $result = 1;
                    $resultArr['count'] = mysqli_num_rows($select);
                break;
            
            default:
                
                break;
        }

        // gettype('e');
        

        $resultArr['result'] = $result;
        return $resultArr;

    } //executeQuery

    //Insert Function 
    public function insert($table, $dataArray){

        $dataArray = $this->validateDataArray($dataArray);
        $column = array_keys($dataArray);
        $data = array_values($dataArray);

        $bindParam = $data;

        $column = implode("`, `",$column);
        $data = implode("','",$data);

        $query = "INSERT INTO `$table` ( `$column` ) VALUES('$data') ";

        return $this->executeQuery($query, 'insert', $bindParam);

    } // get all refeence function over

    //Query Update Function
    public function update($table, $dataArray, $whereArray = null){
    
        $dataArray = $this->validateDataArray($dataArray);
        $whereArray = $this->validateDataArray($whereArray);

        $data = array();
        foreach($dataArray as $field => $val) {
            $data[] = "$field = '$val'";
        }

        $where = array();
        if(is_array($whereArray)){

            foreach($whereArray as $column => $val) {
                $where[] = "$column = '$val'";
            }
        }

        $query = "UPDATE ".$table." SET " . join(', ', $data);
        
        if(count($where) > 0){
            $query .= " WHERE ". join(' AND ', $where);
        }

        return $this->executeQuery($query, 'update');
        
        
    } // query update 

    public function delete($table, $whereArray, $operator = "AND"){

        $whereArray = $this->validateDataArray($whereArray);

        $where = array();
        foreach($whereArray as $column => $val) {
            $where[] = "$column = '$val'";
        }

        $query = "DELETE FROM ".$table." WHERE ". join(' '.$operator.' ', $where) ." ";

        return $this->executeQuery($query, 'delete');

    } // Delete end

    public function count($table, $whereArray){
        
        $whereArray = $this->validateDataArray($whereArray);

        $where = array();
        foreach($whereArray as $column => $val) {
            $where[] = "$column = '$val'";
        }

        $query = "SELECT `id` FROM ".$table;

        if(count($whereArray) > 0){
            $query .= " WHERE ". join(' AND ', $where);
        }

        $executeResult =  $this->executeQuery($query, 'count');

        $count = 0;
        if($executeResult['result'] == 1){
            $count = $executeResult['count'];
        }

        return $count;

    } // Delete end



    // General FUnctions
    public function validateData($data){
        
        $data = mysqli_real_escape_string($this->localhost, trim($data));
        
        return $data;

    } //validateData

    public function validateDataArray($arr){

        $this->arr = $arr;

        if(is_array($this->arr)){


            foreach($this->arr as $key => $value) {
                if(is_array($value)){

                    foreach($value as $sub_key => $sub_value) {

                        if(!is_array($value)){
                            
                            $this->arr[$sub_key] = mysqli_real_escape_string($this->localhost, trim($sub_value) );

                        }else{

                            $this->arr[$sub_key] = $sub_value;

                        } // inside array if end

                    } // inside foreach end

                }else{
                    
                    $this->arr[$key] = mysqli_real_escape_string($this->localhost, trim($value) );

                } // check array or not end
                
            } // fioreach end
        } // if check array

        return $this->arr;

    } //validateDataArray

    public function auditTrails($auditArr){

        $user_id = VHESTA_USER_ID;

        $action = $auditArr['action'];
        $desc = $auditArr['description'];

        $getGlobalData = DBOperations::getGlobalData();
        $user_agent = $getGlobalData['user_agent'];
        $ip_address = $getGlobalData['ip_address'];

        $insertArr = array(
            'user_id' => $user_id,
            'action' => $action,
            'description' => $desc,
            'user_agent' => $user_agent,
            'ip_address' => $ip_address
        );
        $this->insert('audit_trail', $insertArr);

    }



} // DBOperations Class End 

// $dbOpertionsObj = new DBOperations($localhost);

?>