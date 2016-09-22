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
        $sql = "SELECT * FROM oportunity ".$filter_sql." ORDER BY id DESC";
        $result = mysqli_query($connection, $sql);
        $opotunities = array();
        while ($o = mysqli_fetch_object($result)) {
            if ($o != null) {
                $oportunity = new stdClass();
                $oportunity = $o;
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
            $oportunity->creator = UserDAO::getBasicUserById($oportunity->creator_id);
        }
        return $oportunity;
    }
}

?>