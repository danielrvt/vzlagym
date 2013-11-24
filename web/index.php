<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 2:36 AM
 */

require_once __DIR__."/../src/app.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

// todos los requests con json en el header son parseados
// como json.
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// routes
$app->get("/gyms", function (Request $request) use ($app) {

    $data = array(
        "reciever" => "you!",
        "message" => "fuck"
    );
    $response = $app->json($data);

    return $response;
});


$app->get("/", function (Request $request) use ($app){

    $data = array(
        "url" => "root",
        "message" => "fuck"
    );
    $response = $app->json($data);

    return $response;
});


$app->run();