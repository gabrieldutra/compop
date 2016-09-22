<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

require 'connection.php';
require 'userDao.php';

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
    $interest = $_GET["interest"];
    if($validateKey->result){
        if($id == 0 || $id == $validateKey->user->id){
            $user = $validateKey->user; 
            $response->status(200);          
            echo json_encode($user);       
        } else if($validateKey->user->level >= 1 /* || user of the $id is interest in an oportunity that the request user owns */){
            $user = UserDAO::getUserById($id);
            if(empty($user)) $response->status(204);
            else $response->status(200);  
            echo json_encode($user);
        } else $response->status(403);
    } else $response->status(401);
});

/** POST /users - User registration
* @param Body - User data object
* @return JSON - the response
*/
$app->post('/users', function () {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $data = json_decode($request->getBody());
    $result = UserDAO::insertUser($data);
    $response->status($result->status);
});

/** PUT /users/:id - User registration
* @param :id int - id of the user to be updated
* @param Body - User data object
* @return JSON - the response
*/
$app->put('/users/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $authorization = \Slim\Slim::getInstance()->request->headers->get("AuthKey");
    $validateKey = UserDAO::checkAuthorizationKey($authorization);
    $data = json_decode($request->getBody());    
    if($validateKey->result){
        if($id == 0 || $id == $validateKey->user->id){
            unset($data->level);
            $result = UserDAO::updateUser($validateKey->user->id, $data);            
            $response->status($result->status);     
        } else if($validateKey->user->level >= 2){
            $result = UserDAO::updateUser($id, $data);            
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
    $filter->keyword = $_GET['keyword'];
    $filter->approved = 1;
    if(isset($_GET["status"])) $filter->status = $_GET['status'];
    if(isset($_GET["approved"]) && $validateKey->result && $validateKey->user->level >= 1) $filter->approved = $_GET['approved'];
    $oportunities = OportunityDAO::getOportunities($filter);
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

$app->run();

?>