<?php 

class DBOperations extends GeneralFunctions{

    protected $localhost, $database;

    public function __construct($host, $db){
        $this->localhost = $host;
        $this->database = $db;
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
            $data[] = "`$field` = '$val'";
        }

        $where = array();
        if(is_array($whereArray)){

            foreach($whereArray as $column => $val) {
                $where[] = "`$column` = '$val'";
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


    public function checkLogin($checkArr){

        $arr = $this->validateDataArray($checkArr);

        $admin_user_id = 0;
        $r_key = 0;
        $access_code = 10;

        $key_verify = 0;

        if(isset($_SESSION['admin_user_id'])){
            $admin_user_id = $_SESSION['admin_user_id'];
            $r_key = $_SESSION['admin_r_key'];
            $access_code = $checkArr['page_level_code'];
        

        
            $today = Date("Y-m-d H:i:s");
            $yesterday = Date("Y-m-d H:i:s", strtotime("-24 hours"));

            $this->select = mysqli_query($this->localhost,"SELECT lH.`r_key`, aD.`level`
                            FROM `login_history` AS lH 
                            INNER JOIN `admin` AS aD ON aD.`id` = lH.`user_id` 
                            WHERE lH.`user_id`='$admin_user_id' AND (lH.`created` BETWEEN '$yesterday' AND '$today')  ORDER BY lH.`id` DESC LIMIT 0,1  ");
            $this->fetch = mysqli_fetch_array($this->select);

            if(password_verify($r_key,$this->fetch['r_key']) && $this->fetch['level'] <= $access_code ){
                
                // verified 
                $key_verify = 1;

            } // password veriy if end 

        }

        return $key_verify;


    } //checkLogin

    public function loginAdmin($loginarr){

        $arr = $this->validateDataArray($loginarr);

        $username = $arr['username'];
        $password = $arr['password'];

        $select = mysqli_query($this->localhost,"SELECT `password`,`id`,`level` FROM `admin` WHERE `username`='$username' ");
        $fetch = mysqli_fetch_array($select);

        $pswd_verify = 0;
        if(password_verify($password,$fetch['password'])){
            // verified 
            $pswd_verify = 1;

            //Insert history
            $getGlobalData = $this->getGlobalData();
            $user_agent = $getGlobalData['user_agent'];
            $ip_address = $getGlobalData['ip_address'];
            $expiry_date = $getGlobalData['expiry_date'];
            $rand_key = $getGlobalData['rand_key'];
            $user_id = $fetch['id'];

            $arr = array(
                'user_id'=>$user_id,
                'r_key'=> password_hash($rand_key, PASSWORD_DEFAULT),
                'user_agent' => $user_agent,
                'ip_address' => $ip_address,
                'expiry_date' => $expiry_date
            );

            $this->insert('login_history',$arr);
            
            $_SESSION['admin_user_id'] = $user_id;
            $_SESSION['admin_r_key'] = $rand_key;
            $_SESSION['admin_name'] = $username;
            $_SESSION['admin_level'] = $fetch['level'];

        } // password veriy if end 

        return array('result'=>$pswd_verify);

    } //loginUser function end 

    public function auditTrails($auditArr){

        $user_id = $_SESSION['admin_user_id'];

        $action = $auditArr['action'];
        $desc = $auditArr['description'];

        $getGlobalData = $this->getGlobalData();
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

$dbOpertionsObj = new DBOperations($localhost, $database);

?>