<?php 

class InterestDAO{
    /** Get Interests
    * @param $uid int - user id
    * @param $oid int - oportunity id
    * @return InterestDAO[] - Interests with the filters
    */
    public static function getInterests($uid, $oid){
        $connection = Connection::getConnection();
        $text="";
        if(isset($uid)) $text.="WHERE user_id='$uid'";
        if(isset($oid)) {
            if(!empty($text)) $text.=" AND ";
            else $text.="WHERE ";
            $text.="oportunity_id='$oid'";
        }
        $sql = "SELECT * FROM interest ".$text;
        $result = mysqli_query($connection, $sql);
        $interests = array();
        while ($i = mysqli_fetch_object($result)) {
            if ($i != null) {
                $interest = new stdClass();
                $interest = $i;
                $interest->user_name = UserDAO::getUserById($interest->user_id)->name;
                $interest->oportunity_title = OportunityDAO::getOportunityById($interest->oportunity_id)->title;
                $interests[] = $interest;
            }
        }
        return $interests;
    }
    
    /** Delete interests
    * @param $uid int - user id
    * @param $oid int - oportunity id 
    * @return object response
    */
    public static function deleteInterest($uid, $oid){
        $connection = Connection::getConnection();
        $text="";
        if(isset($uid)) $text.="WHERE user_id='$uid'";
        if(isset($oid)) {
            if(!empty($text)) $text.=" AND ";
            else $text.="WHERE ";
            $text.="oportunity_id='$oid'";
        }
        $sql = "DELETE FROM interest ".$text;
        if(!empty($text)){
            $result = mysqli_query($connection, $sql);    
            $affected = mysqli_affected_rows($connection);
        } else {
            $result = true;
            $affected = 0;
        }
        $response = new stdClass();  
        if($result){
            if($affected == 0){   
                $response->result = false;
                $response->status = 400;             
            } else {
                $response->result = true;
                $response->status = 204;                
            }
        } else {               
            $response->result = true;
            $response->status = 204; 
            $response->result = false;
            $response->status = 500;
        }
        return $response;
    }
}

?>