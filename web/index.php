<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 2:36 AM
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// definitions
$app["debug"] = true;

// routes
$app->get("/gyms", function (Request $request) {

    $data = array(
        "reciever" => "you!",
        "message" => "fuck"
    );
    $response = new Response(json_encode($data), 200, array('Content-type'=> 'application/json'));

    return $response;
});


$app->get("/", function (Request $request) {

    $data = array(
        "url" => "/",
        "message" => "fuck"
    );
    $response = new Response(json_encode($data), 200, array('Content-type'=> 'application/json'));

    return $response;
});


$app->run();