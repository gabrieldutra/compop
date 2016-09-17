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
    if($validateKey->result){
        if($id == 0){
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
* @return JSON - the registered user 
*/

$app->post('/users', function () {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $data = json_decode($request->getBody());
    if(isset($data->email) && isset($data->password) && isset($data->name)){
        //TODO
    } else $response->status(400);
});

$app->run();

?>