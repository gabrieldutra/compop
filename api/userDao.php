<?php

class userDAO {
    /*
    * Get All Users
    * - Return all users
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
    
    /*
    * Login
    * - Return the response object with the user in case of success
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
    
    /*
    * Check Authorization Key
    * - $key = The key that will be validated
    * - Return a json with the result and the user in case it's a valid key
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
            }
        }
        return $response;
    }
    
    /*
    * Generate access key
    * - $user = user to have the key generated
    * - Return a generated key for this user to access the system (valid until 00:00)
    */
    public static function generateKey($user) {
        return md5("uskey" . $user->email . $user->password . date("d"));
    }
}

?>