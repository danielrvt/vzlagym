<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 2:36 AM
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// definitions
$app["debug"] = true;

// routes
$app->get("/", function () {
    return json_encode(array(
        "message" => "fuck you!"
    ));
});


$app->run();