<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

require 'connection.php';
require 'userDao.php';

date_default_timezone_set("America/Sao_Paulo");


$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

// /login

$app->post('/login', function() {
    $request = \Slim\Slim::getInstance()->request();
    $response = \Slim\Slim::getInstance()->response();
    $data = json_decode($request->getBody());
    $login = UserDAO::login($data->email, $data->password);
    if($login->result) $response->status(200);
    else $response->status(403);
    echo json_encode($login);
});

// /users - Temporary for tests

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

$app->run();

?>