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
        $queryBuilder = $app["db"]->createQueryBuilder();
        $queryBuilder
            ->select('g.id', 'g.name', 'g.address', 'g.lat', 'g.lon', 'g.logo', 'c.name as city')
            ->from('gym', 'g')
            ->join('g','cities', 'c', 'g.city=c.id');

        $gyms = $queryBuilder->execute()->fetchAll();

        $queryBuilder = $app["db"]->createQueryBuilder();
        $queryBuilder
            ->select('p.img')
            ->from('pin', 'p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1);

        $pin = $queryBuilder->execute()->fetch();

        $result = array(
            "pin_img" => $pin['img'],
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
        $queryBuilder = $app["db"]->createQueryBuilder();
        $queryBuilder
            ->select('g.id', 'g.name', 'g.address', 'g.lat', 'g.lon', 'g.logo', 'c.name as city')
            ->from('gym', 'g')
            ->join('g','cities', 'c', 'g.city=c.id')
            ->where($queryBuilder->expr()->eq('g.id', $queryBuilder->createNamedParameter($id)));


        return $app->json($queryBuilder->execute()->fetch());
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
