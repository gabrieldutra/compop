<?php

class UserDAO {
    /** Get All Users
    * @return UserDAO[] - all users
    */
    public static function getAll(){
        $connection = Connection::getConnection();
        $sql = "SELECT * FROM user ORDER BY name";
        $result = mysqli_query($connection, $sql);
        $users = array();
        while ($u = mysqli_fetch_object($result)) {
            if ($u != null) {
                $user = new stdClass();
                $user = $u;
                $users[] = $user;
            }
        }
        return $users;
    }
    
    /** Get User by Id
    * @param $id int - id to be recovered
    * @return UserDAO - user that has the id
    */
    public static function getUserById($id){
        $connection = Connection::getConnection();
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = mysqli_query($connection, $sql);
        $user = mysqli_fetch_object($result);
        unset($user->password);
        return $user;
    }
    
    /** Login
    * @return stdClass - the response object with the user in case of success
    */
    public static function login($email, $password){
        $connection = Connection::getConnection();
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = MD5('$password')";
        $result = mysqli_query($connection, $sql);
        $response = new stdClass();
        if(mysqli_num_rows($result) == 0){
            $response->result = false;
        } else {
            $user = mysqli_fetch_object($result);
            $response->result = true;
            $response->auth_key = UserDAO::generateKey($user);
            $response->user = $user;
            unset($response->user->password);
        }
        return $response;
    }
    
    /** Insert new user
    * @param $user UserDAO - user to be created
    * @return object response
    */
    public static function insertUser($user){
        $connection = Connection::getConnection();
        $user->password = md5($user->password);
        if(!isset($user->receive_email)) $user->receive_email = 1;
        $verifysql = "SELECT * FROM user WHERE email='$user->email'";
        $sql = "INSERT INTO user (name,email,password,receive_email,registry,phone,mobile_phone,about)"
                . " VALUES('$user->name', '$user->email', '$user->password', '$user->receive_email', '$user->registry', '$user->phone', '$user->mobile_phone', '$user->about')";
        $response = new stdClass();
        $valid_email = filter_var($user->email, FILTER_VALIDATE_EMAIL);
        $user_not_exist = false;
        if(strlen($user->name) <= 5 || !$valid_email || strlen($user->password) <= 5){  
            $response->result = false;
            $response->status = 400;
            return $response;
        }     
        $verifyquery = mysqli_query($connection, $verifysql);
        $user_not_exist = (mysqli_num_rows($verifyquery) == 0);         
        if(!$user_not_exist){
            $response->result = false;
            $response->status = 409;
            return $response;
        }
        $result = mysqli_query($connection, $sql);
        if($result){
            $response->result = true;
            $response->status = 201;
        } else {                
            $response->result = false;
            $response->status = 500;
        }
        
        return $response;
    }
    
    /** Check Authorization Key
    * @param $key String - The key that will be validated
    * @return stdClass - a json with the result and the user in case it's a valid key
    */
    public static function checkAuthorizationKey($key) {
        $users = UserDAO::getAll();
        $response = new stdClass();
        $response->result = false;
        foreach ($users as $user) {
            $genKey = UserDAO::generateKey($user);
            if ($genKey == $key) {
                $response->result = true;
                $response->user = $user;
                unset($response->user->password);
            }
        }
        return $response;
    }
    
    /** Generate access key
    * @param $user UserDAO - user to have the key generated
    * @return String - a generated key for this user to access the system (valid until 00:00)
    */
    public static function generateKey($user) {
        return md5("uskey" . $user->email . $user->password . date("d"));
    }
}

?>