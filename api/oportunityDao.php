<?php 

class OportunityDAO{    
    /** Get Oportunities 
    * @param $filter - object to filter oportunities
    * @return OportunityDAO[] - oportunities
    */
    public static function getOportunities($filter){
        $connection = Connection::getConnection();
        $filter_sql = "WHERE (title LIKE '%".$filter->keyword."%' OR description LIKE '%".$filter->keyword."%')";
        if(isset($filter->status)) $filter_sql.=" AND status=".$filter->status;
        if(isset($filter->approved)) $filter_sql.=" AND approved=".$filter->approved;
        $sql = "SELECT * FROM oportunity ".$filter_sql." ORDER BY updated DESC";
        $result = mysqli_query($connection, $sql);
        $oportunities = array();
        while ($o = mysqli_fetch_object($result)) {
            if ($o != null) {
                $oportunity = new stdClass();
                $oportunity = $o;
                if(empty($oportunity->photo)) $oportunity->photo = "images/sem_logo.png";
                $oportunity->creator = UserDAO::getBasicUserById($oportunity->creator_id);
                $oportunities[] = $oportunity;
            }
        }
        return $oportunities;
    }
    
    /** Get Featured Oportunities 
    * @param $filter - object to filter oportunities
    * @return OportunityDAO[] - oportunities
    */
    public static function getFeaturedOportunities($filter){
        $connection = Connection::getConnection();
        $filter_sql = "SELECT oportunity.*, COUNT(interest.oportunity_id) as interested FROM interest JOIN oportunity ON oportunity.id = interest.oportunity_id GROUP BY oportunity.id HAVING oportunity.approved='1' ORDER BY interested DESC, updated DESC";
        if(isset($filter->limit)) $filter_sql.="  LIMIT ".$filter->limit;
        $sql = $filter_sql;
        $result = mysqli_query($connection, $sql);
        $oportunities = array();
        while ($o = mysqli_fetch_object($result)) {
            if ($o != null) {
                $oportunity = new stdClass();
                $oportunity = $o;
                if(empty($oportunity->photo)) $oportunity->photo = "images/sem_logo.png";
                $oportunity->creator = UserDAO::getBasicUserById($oportunity->creator_id);
                $oportunities[] = $oportunity;
            }
        }
        return $oportunities;
    }
    
    /** Get Recent Oportunities 
    * @param $filter - object to filter oportunities
    * @return OportunityDAO[] - oportunities
    */
    public static function getRecentOportunities($filter){
        $connection = Connection::getConnection();
        $filter_sql = "SELECT * FROM oportunity WHERE oportunity.approved='1' ORDER BY updated DESC";
        if(isset($filter->limit)) $filter_sql.="  LIMIT ".$filter->limit;
        $sql = $filter_sql;
        $result = mysqli_query($connection, $sql);
        $oportunities = array();
        while ($o = mysqli_fetch_object($result)) {
            if ($o != null) {
                $oportunity = new stdClass();
                $oportunity = $o;
                if(empty($oportunity->photo)) $oportunity->photo = "images/sem_logo.png";
                $oportunity->creator = UserDAO::getBasicUserById($oportunity->creator_id);
                $oportunities[] = $oportunity;
            }
        }
        return $oportunities;
    }
    
    
    /** Get Oportunity By Id
    * @param $id int - Id of the oportunity
    * @return OportunityDAO[] - oportunity that has the id
    */
    public static function getOportunityById($id){
        $connection = Connection::getConnection();
        $sql = "SELECT * FROM oportunity WHERE id='".$id."'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) != 0){
            $oportunity = mysqli_fetch_object($result);
            if(empty($oportunity->photo)) $oportunity->photo = "images/sem_logo.png";
            $oportunity->creator = UserDAO::getBasicUserById($oportunity->creator_id);
        }
        return $oportunity;
    }
    
    /** Insert new oportunity
    * @param $oportunity OportunityDAO - oportunity to be created
    * @return object response
    */
    public static function insertOportunity($oportunity){
        $connection = Connection::getConnection();
        $verifysql = "SELECT * FROM oportunity WHERE title='$oportunity->title'";
        
        if(!isset($oportunity->status)) $oportunity->status = 0;
        $sql = "INSERT INTO oportunity (title,creator_id,status,description,inscription,photo)"
                . " VALUES('$oportunity->title','$oportunity->user_id','$oportunity->status','$oportunity->description','$oportunity->inscription','$oportunity->photo')";
        $response = new stdClass();
        $oportunity_not_exist = false;
        if(strlen($oportunity->title) <= 5){  
            $response->result = false;
            $response->status = 400;
            return $response;
        }     
        $verifyquery = mysqli_query($connection, $verifysql);
        $oportunity_not_exist = (mysqli_num_rows($verifyquery) == 0);         
        if(!$oportunity_not_exist){
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
    
    /** Update oportunity
    * @param $id int - oportunity id to update   
    * @param $user OportunityDAO - oportunity object to update
    * @return object response
    */
    public static function updateOportunity($id, $oportunity){
        $connection = Connection::getConnection();        
        $text="";
        if(isset($oportunity->status)) $text.="status='$oportunity->status'";
        if(isset($oportunity->description)) {
            if(!empty($text)) $text.=" ,";
            $text.="description='$oportunity->description'";
        }
        if(isset($oportunity->approved)) {
            if(!empty($text)) $text.=" ,";
            $text.="approved='$oportunity->approved'";
        }
        if(isset($oportunity->inscription)) {
            if(!empty($text)) $text.=" ,";
            $text.="inscription='$oportunity->inscription'";
        }
        if(isset($oportunity->photo)) {
            if(!empty($text)) $text.=" ,";
            $text.="photo='$oportunity->photo'";
        }
        $sql = "UPDATE oportunity SET ".$text." WHERE id = $id";
        $response = new stdClass();   
        if(empty($text)){
            $response->result = false;
            $response->status = 400;
            return $response;
        }     
        $result = mysqli_query($connection, $sql);    
        if($result){
            $response->result = true;
            $response->status = 204;
        } else {                
            $response->result = false;
            $response->status = 500;
        }
        return $response;
    }
    
    /** Delete oportunity
    * @param $id int - oportunity id to delete   
    * @return object response
    */
    public static function deleteOportunity($id){
        $connection = Connection::getConnection();
        InterestDAO::deleteInterest(NULL, $id);
        $sql = "DELETE FROM oportunity WHERE id='$id'";
        $result = mysqli_query($connection, $sql);    
        $affected = mysqli_affected_rows($connection);
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