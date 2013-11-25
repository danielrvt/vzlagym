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
use Silex\Provider\DoctrineServiceProvider;

/**
 * Class Gym
 * @package VzlaGym
 *
 * Representa un gimnasio.
 */
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

    /**
     * Obtiene todos los gimnasios registrados.
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function getAll(Request $request, Application $app)
    {
        $sql = "select * from gym";
        $gyms = $app['db']->fetchAll($sql);

        $sql = "select * from pin limit 1";
        $pin = $app['db']->fetchColumn($sql, array(0), 1);

        $result = array(
            "pin_img" => $pin,
            "gyms" => $gyms
        );

        return $app->json($result);
    }

    /**
     * Obtiene un gimnasio en especifico dado su
     * identificador de base de datos.
     *
     * @param Request $request
     * @param Application $app
     * @param $id
     */
    public function get(Request $request, Application $app, $id) {
        $sql = "select * from gym where id=?";
        $gym = $app['db']->fetchAssoc($sql, array($id));

        $result = $gym;

        return $app->json($result);
    }

    /**
     * Crea un nuevo gimnasio.
     * @param Request $request
     */
    public function post(Request $request)
    {

    }

    /**
     * Modifica los datos de un gimnasio dado su identificador.
     * @param $id
     */
    public function put($id)
    {

    }

    /**
     * Elimina un gimnasio dado su identificador.
     * @param $id
     */
    public function delete($id)
    {

    }
}
