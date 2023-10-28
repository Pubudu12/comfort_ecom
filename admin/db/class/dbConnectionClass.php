<?php
class dbConnector {
    private $localhost;
    private $database;
    private $username;
    private $password;

    function connection($l = HOST,$d = DB,$u = UNAME,$p = PSWD){

        $this->localhost = $l;
        $this->database = $d;
        $this->username = $u;
        $this->password = $p;

        $connect_host = mysqli_connect($this->localhost,$this->username,$this->password);
        $select_db = mysqli_select_db($connect_host,$this->database);

        $connection_arr = array('connection' => $connect_host, 'db' => $select_db);

        if($connect_host && $select_db){
            return $connection_arr;
        }else{
            return mysqli_error($this->localhost);
        }
    } //Connection Function End

}

$dbObj = new dbConnector();
// $connect = $dbObj -> connection(HOST,DB,UNAME,PSWD);
$connect = $dbObj->connection();

$localhost =  $connect['connection'];
$database = $connect['db'];

?>