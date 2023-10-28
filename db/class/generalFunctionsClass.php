<?php 
// General Functions

class GeneralFunctions{


    public function getIp($ip = null, $deep_detect = TRUE){
        // function to get ip address
            if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
                $ip = $_SERVER["REMOTE_ADDR"];
                if ($deep_detect) {
                    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
            return $ip;
    } //getIp functio end 

    public function getGlobalData(){

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ip_address = $this->getIp();
        $expiry_date = Date("Y-m-d", strtotime(" +10 Days "));
        $rand_key = mt_rand(10000,99999);

        return array(
            'rand_key'=> $rand_key,
            'user_agent' => $user_agent,
            'ip_address' => $ip_address,
            'expiry_date' => $expiry_date
        );

    } //getGlobalData function end 

} //GeneralFunctions

?>