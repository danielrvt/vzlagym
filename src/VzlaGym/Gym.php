<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 11/24/13
 * Time: 12:49 PM
 */

namespace VzlaGym;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Gym
{
    public $name = null;
    public $state = null;
    public $city = null;
    public $address = null;
    public $logo = null;
    public $location = array(
        "lat" => null,
        "lon" => null
    );
    public $scheduleOfAttention = array(
      "" => array(
          "openingTime" => null,
          "closingTime" => null,
      )
    );

    public static function getAll(Request $request, Application $app)
    {
        $data = array(
            "pin_img" => "AAAadasfADF234Ds2234SDfasd3sfd3fd5534t",
            "gyms" => array(
                array(
                    "name" => "Universal Gym",
                    "state" => "Miranda",
                    "city" => "Caracas",
                    "address" => "CC. Los Campitos, piso 3, Los Campitos, Baruta.",
                    "location" => array(
                        "lat" => -64.123456,
                        "lon" => 9.12346
                    ),
                ),
                array(
                    "name" => "Universal Gym",
                    "state" => "Miranda",
                    "city" => "Caracas",
                    "address" => "CC. Los Campitos, piso 3, Los Campitos, Baruta.",
                    "location" => array(
                        "lat" => -64.123456,
                        "lon" => 9.12346
                    ),
                )
            )
        );

        return $app->json($data);
    }

    public function get(Request $request, Application $app, $id) {

    }

    public function post(Request $request)
    {

    }

    public function put()
    {

    }

    public function delete()
    {

    }
}
