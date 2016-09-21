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

$app->run();

?>