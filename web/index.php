<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 2:36 AM
 *
 * Front controller, all requests to the api
 * go through here.
 */

require_once __DIR__."/../src/app.php";

use Symfony\Component\HttpFoundation\Request;

// todos los requests con json en el header son parseados
// como json.
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// routes
$app->get("/gyms", 'VzlaGym\\Gym::getAll');
$app->post("/gyms", 'VzlaGym\\Gym::post');
$app->get("/gyms/{id}", 'VzlaGym\\Gym::get');

$app->run();