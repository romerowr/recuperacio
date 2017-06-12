<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config.slim.php';

$app = new \Slim\App(['settings'=>$config]);
$container = $app->getContainer();
$container['db']=function($c)
{
    $db=$c['settings']['db'];
    $pdo=new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    return $pdo;
};

// Fin del PDO



 // Mostrar el listado de usuarios mostrando sus latitudes y longitudes
 // Ruta: /ids
 

    
$app->get('/ids', function(Request $req, Response $res){
    $stmt=$this->db->prepare("SELECT latitud, longitud FROM users");
    $stmt->execute();
    $result=$stmt->fetchAll();
    return $this->response->withJson($result);
});

// Mostrar un usuario en concreto para saber sus latitudes y longitudes
// Ruta: /id/id
 

$app->get('/id/{id}',function(Request $req, Response $res, $args)
{
    $id=(int)$args['id'];
    $stmt=$this->db->prepare("SELECT latitud, longitud FROM users WHERE idusers=:idusers");
    $stmt->bindParam(':idusers',$id);
    $stmt->execute();
    $result=$stmt->fetchAll();
    return $this->response->withJson($result);
});


$app->run();    