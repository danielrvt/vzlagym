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
use Symfony\Component\HttpFoundation\Response;

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
    public $lat = null;
    public $lon = null;

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
    public function post(Request $request, Application $app)
    {
        $gym = new Gym();

        $gym->name = $request->request->get('name');
        $gym->address = $request->request->get('address');
        $gym->lat = $request->request->get('lat');
        $gym->lon = $request->request->get('lon');
        $gym->city = $request->request->get('city');
        $gym->logo = $request->request->get('logo');

        if ($gym->isValid()) {
            try {
                $app['db']->insert('gym', array(
                    'name' => $gym->name,
                    'address' => $gym->address,
                    'lat' => $gym->lat,
                    'lon' => $gym->lon,
                    'city' => $gym->city,
                    'logo' => $gym->logo
                ));

                return new Response("Ok", 200);

            } catch (Exception $e) {
               return new Response($e, 300);
            }
        }
        return new Response("Not Valid", 300);
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

    /**
     * Valida el objeto
     */
    public function isValid() {
        return true;
    }
}
