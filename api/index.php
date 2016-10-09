<?php
date_default_timezone_set('America/Sao_Paulo');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

require 'connection.php';
require 'userDao.php';
require 'oportunityDao.php';
require 'interestDao.php';

date_default_timezone_set("America/Sao_Paulo");


$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

/** POST /login
* @param Body - Object with {"email": "email@example.com", "password": "passwd"} 
* @return JSON - all the users in case the request user has permission
*/
$app->post('/login', function() {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $data = json_decode($request->getBody());
    $login = UserDAO::login($data->email, $data->password);
    if($login->result) $response->status(200);
    else $response->status(403);
    echo json_encode($login);
});

/** GET /users
* @return JSON - all the users in case the request user has permission
*/
$app->get('/users', function () {
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $users = [];
    if($validateKey->result && $validateKey->user->level >= 1) {
        $users = UserDAO::getAll();
        $response->status(200);        
    } else $response->status(401);
    echo json_encode($users);
});

/** GET /users/:id
* @param :id int - id of the user to be returned
* @return JSON - the user object (in case id = 0 the user is who asked)
*/
$app->get('/users/:id', function ($id) {
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    if(isset($_GET["interests"])) $interests = $_GET["interests"];
    if($validateKey->result && ($id == 0 || $id == $validateKey->user->id)){
        $user = $validateKey->user; 
        $response->status(200);          
        echo json_encode($user);       
    } else if($validateKey->result && ($validateKey->user->level >= 1 || UserDAO::userCanSeeUser($validateKey->user->id,$id))){
        $user = UserDAO::getUserById($id);
        if(empty($user)) $response->status(204);
        else $response->status(200);  
        echo json_encode($user);
    } else {
        $user = UserDAO::getBasicUserById($id);
        if(empty($user)) $response->status(204);
        else $response->status(200);  
        echo json_encode($user);
    }
});

/** POST /users - User registration
* @param Body - User data object
* @return status code
*/
$app->post('/users', function () {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $data = json_decode($request->getBody());
    $result = UserDAO::insertUser($data);
    $response->status($result->status);
});

/** PUT /users/:id - User update
* @param :id int - id of the user to be updated
* @param Body - User data object
* @return status code
*/
$app->put('/users/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $data = json_decode($request->getBody());    
    if($validateKey->result){
        if($validateKey->user->level >= 2 && $id != 0){
            $result = UserDAO::updateUser($id, $data);            
            $response->status($result->status);
        } else if($id == 0 || $id == $validateKey->user->id){
            unset($data->level);
            $result = UserDAO::updateUser($validateKey->user->id, $data);            
            $response->status($result->status);     
        } else $response->status(403);
    } else $response->status(401);
});

/** GET /oportunities
* @param $keyword String - keyword to locate oportunity
* @param $status int - filter using the status of the oportunity
* @param $approved int - filter to show not approved oportunities (only for admins)
* @return JSON - all the oportunities with the filter
*/
$app->get('/oportunities', function () {
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $filter = new stdClass();
    if(isset($_GET["keyword"])) $filter->keyword = $_GET['keyword'];
    $filter->approved = 1;
    if(isset($_GET["status"])) $filter->status = $_GET['status'];
    if(isset($_GET["user"])) $filter->user_i = $_GET['user'];
    if(isset($_GET["approved"]) && $validateKey->result && $validateKey->user->level >= 1) $filter->approved = $_GET['approved'];
    $oportunities = OportunityDAO::getOportunities($filter);
    if(empty($oportunities)) $response->status(204);  
    else {
        $response->status(200); 
        echo json_encode($oportunities);
    }    
});

/** GET /featured
* @param $limit int - limit of results
* @return JSON - $limit featured oportunities with the filter
*/
$app->get('/featured', function () {
    $response = \Slim\Slim::getInstance()->response();
    $filter = new stdClass();
    if(isset($_GET['limit'])) $filter->limit = $_GET['limit'];
    $oportunities = OportunityDAO::getFeaturedOportunities($filter);
    if(empty($oportunities)) $response->status(204);  
    else {
        $response->status(200); 
        echo json_encode($oportunities);
    }    
});

/** GET /recent
* @param $limit int - limit of results
* @return JSON - $limit recent oportunities with the filter
*/
$app->get('/recent', function () {
    $response = \Slim\Slim::getInstance()->response();
    $filter = new stdClass();
    if(isset($_GET['limit'])) $filter->limit = $_GET['limit'];
    $oportunities = OportunityDAO::getRecentOportunities($filter);
    if(empty($oportunities)) $response->status(204);  
    else {
        $response->status(200); 
        echo json_encode($oportunities);
    }    
});

/** GET /oportunities/:id
* @param :id int - id of the oportunity to be returned
* @return JSON - the oportunity of the id
*/
$app->get('/oportunities/:id', function ($id) {
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $oportunity = OportunityDAO::getOportunityById($id);
    if(empty($oportunity)) $response->status(204);  
    else {
        if($oportunity->approved == 1 || ($validateKey->result && $validateKey->user->level >= 1)){
            $response->status(200); 
            echo json_encode($oportunity);
        } else $response->status(403);
        
    }    
});

/** POST /oportunities - Oportunity creation
* @param Body - Oportunity data object
* @return JSON - the response
*/
$app->post('/oportunities', function () {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    if($validateKey->result){
        $data = json_decode($request->getBody());
        $data->user_id = $validateKey->user->id;
        $result = OportunityDAO::insertOportunity($data);
        $response->status($result->status);
    } else $response->status(401);
});

/** PUT /oportunities/:id - Oportunity update
* @param :id int - id of the oportunity to be updated
* @param Body - Oportunity data object
* @return status code
*/
$app->put('/oportunities/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $data = json_decode($request->getBody());
    $oportunity = OportunityDAO::getOportunityById($id);
    if($validateKey->result){
        if($validateKey->user->level >= 1){
            $result = OportunityDAO::updateOportunity($id, $data);            
            $response->status($result->status);
        } else if($oportunity->creator_id == $validateKey->user->id){
            unset($data->approved);
            $result = OportunityDAO::updateOportunity($id, $data);            
            $response->status($result->status);     
        } else $response->status(403);
    } else $response->status(401);
});

/** DELETE /oportunities/:id - Oportunity deletion
* @param :id int - id of the oportunity to be deleted
* @return status code
*/
$app->delete('/oportunities/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $oportunity = OportunityDAO::getOportunityById($id);
    if($validateKey->result){
        if($validateKey->user->level >= 1){
            $result = OportunityDAO::deleteOportunity($id);            
            $response->status($result->status);
        } else if($oportunity->creator_id == $validateKey->user->id){
            unset($data->approved);
            $result = OportunityDAO::deleteOportunity($id);            
            $response->status($result->status);     
        } else $response->status(403);
    } else $response->status(401);
});

/** GET /interests
* @param $user_id int - user id
* @param $opotunity_id int - oportunity id
* @return JSON - all the interests with the filter
*/
$app->get('/interests', function () {
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    if(isset($_GET['user_id'] && is_numeric($_GET['user_id'])) $uid = $_GET['user_id'];
    if(isset($_GET['oportunity_id'] && is_numeric($_GET['oportunity_id'])) $oid = $_GET['oportunity_id'];
    $interests = InterestDAO::getInterests($uid,$oid);
    if(empty($interests)) $response->status(204);  
    else {
        $response->status(200); 
        echo json_encode($interests);
    }    
});

/** POST /interests - Mark interest
* @param Body - Object with the oportunity id
* @return JSON - the response
*/
$app->post('/interests', function () {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    if($validateKey->result){
        $data = json_decode($request->getBody());
        $data->user_id = $validateKey->user->id;
        if(is_numeric($data->oportunity_id)){
            $oportunity = OportunityDAO::getOportunityById($data->oportunity_id);
            if(!empty($oportunity) && $oportunity->approved == 1){
                $result = InterestDAO::insertInterest($data);
                $response->status($result->status);    
            } else $response->status(400);                        
        } else $response->status(400);
    } else $response->status(401);
});

/** DELETE /interests/:id - Oportunity deletion
* @param :id int - id of the oportunity to delete the interest
* @return status code
*/
$app->delete('/interests/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);    
    if($validateKey->result){
        $result = InterestDAO::deleteInterest($validateKey->user->id,$id);            
        $response->status($result->status);   
    } else $response->status(401);
});

$app->run();

?>