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
