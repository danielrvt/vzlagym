<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 11:48 AM
 *
 * Contiene las inicializaciones de la app e incluye la logica de los
 * servicios.
 */

require_once __DIR__.'/bootstrap.php';

$app = new Silex\Application();

$gym = new \VzlaGym\Gym();

// definitions
$app["debug"] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname'     => 'vzlagym',
        'host'     => '127.0.0.1',
        'user'     => 'vzlagym',
        'password'     => 'vzlagym',
    ),
));
