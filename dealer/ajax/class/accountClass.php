<?php 

class myaccount{

    protected $db, $localhost;

    public $select,$fetch,$update;
    public $result,$message;

    public $email,$password,$c_password,$name;
    public $user_id,$user_type,$ip_address;
    public $mobile_no,$contact_no;
    
    public function __construct($localhost){
        $this->localhost = $localhost;
    }

    public function login($credentials){
        $this->email = $credentials['email'];
        $this->password = $credentials['password'];

        $this->result = 0;
        $this->message = "Email id or password wrong";

        $this->select = mysqli_query($this->localhost,"SELECT `password`,`access_token` FROM `login` WHERE `email`='$this->email' ");

        if(mysqli_num_rows($this->select) == 1){
            $this->fetch = mysqli_fetch_array($this->select);

            $old_password = $this->fetch['password'];
            
            if(password_verify($this->password,$old_password)){
                // login successfull
                unset($_SESSION['user_id']);
                unset($_SESSION['user_type']);
                unset($_SESSION['name']);

                $access_token = $this->fetch['access_token'];

                $this->select = mysqli_query($this->localhost,"SELECT `id`,`name`,`user_type` FROM `users` WHERE `access_token`='$access_token' ");
                $this->fetch = mysqli_fetch_array($this->select);

                if ($this->fetch['user_type'] == 'dealer') {
                    $_SESSION['user_id'] = $this->fetch['id'];
                    $_SESSION['user_type'] = "dealer";
                    $_SESSION['name'] = $this->fetch['name'];
                } 

                // Move cart items to this user
                if(isset($credentials['ip_address'])){
                    $this->ip_address = $credentials['ip_address'];
                    myaccount::guestToAccount($this->ip_address,$this->fetch['id']);
                }

                $this->result = 1;
                $this->message = "Account logged in successfully";

            }// check passwor dhash
        } // check rows


        return array("result"=>$this->result,"message"=>$this->message);

    } // login  function end 

    public function checkUserAccess(){

    } //checkUserAccess

    public function updateUsers($credentials){

        $this->result = 0;
        $this->message = "Failed to update user details";

        $this->name = $credentials['name'];
        $this->mobile_no = $credentials['mobile_no'];
        $this->contact_no = $credentials['contact_no'];
        // $this->email= $credentials['email'];
        
        $p_door_no = $credentials['p_door_no'];
        $p_city = $credentials['p_city'];
        $p_state = $credentials['p_state'];
        $p_zip_code = $credentials['p_zip_code'];

        $t_door_no = $credentials['t_door_no'];
        $t_city = $credentials['t_city'];
        $t_state = $credentials['t_state'];
        $t_zip_code = $credentials['t_zip_code'];

        $default_address = $credentials['default_address'];

        $this->user_id = $credentials['user_id'];

        $this->update = mysqli_query($this->localhost,"UPDATE `users` SET `name`='$this->name',`mobile_no`='$this->mobile_no',`contact_no`='$this->contact_no',`p_door_no`='$p_door_no',`p_city`='$p_city',`p_state`='$p_state',`p_zip_code`='$p_zip_code',`t_door_no`='$t_door_no',`t_city`='$t_city',`t_state`='$t_state',`t_zip_code`='$t_zip_code',`default_address`='$default_address' WHERE `id`='$this->user_id' ");
        if($this->update){
            $this->result = 1;
            $this->message = "User details has been updated";
        }

        return array("result"=>$this->result,"message"=>$this->message);

    } // updateUsers



    // Cart
    private function guestToAccount($ip_address,$user_id){
        $this->user_id = $user_id;
        $this->ip_address = $ip_address;

        // Delete all the previous cart items
        $delete_cart = mysqli_query($this->localhost,"DELETE FROM `cart` WHERE `user_id`='$this->user_id' ");

        //Move all the guest cart items to account cart
        $select_guest_cart = mysqli_query($this->localhost,"SELECT * FROM `guest_cart` WHERE `ip_id`='$this->ip_address' ");
        while($fetch_guest_cart = mysqli_fetch_array($select_guest_cart)){

            $product_id = $fetch_guest_cart['product_id'];
            $qty = $fetch_guest_cart['qty'];
            $size = $fetch_guest_cart['size'];
            $color = $fetch_guest_cart['color'];

            // insert into account user cart

            $insert = mysqli_query($this->localhost,"INSERT INTO `cart` (`user_id`,`product_id`,`qty`,`size`,`color`) VALUES('$this->user_id','$product_id','$qty','$size','$color') ");

        } // wile loop end 

        // Delete guest cart items
        $delete_guest_cart = mysqli_query($this->localhost,"DELETE FROM `guest_cart` WHERE `ip_id`='$this->ip_address' ");

    } // guestToAccount

    public function getCartsItems(){

    } // getCartsItems()

    public function insertCartsItems(){

    } // getCartsItems()


} // myaccount

$myaccountObj = new myaccount($localhost);

?>