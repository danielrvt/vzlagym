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
    public $ranking = 0;

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
            ->join('g', 'cities', 'c', 'g.city=c.id');

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
    public function get(Request $request, Application $app, $id)
    {
        $queryBuilder = $app["db"]->createQueryBuilder();
        $queryBuilder
            ->select('g.id', 'g.name', 'g.address', 'g.lat', 'g.lon', 'g.logo', 'c.name as city')
            ->from('gym', 'g')
            ->join('g', 'cities', 'c', 'g.city=c.id')
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

    /** * Modifica los datos de un gimnasio dado su identificador. * @param $id */
    public function put($id, Application $app, Request $request)
    {
        $gym = new Gym();
        $gym->name = $request->request->get('name');
        $gym->address = $request->request->get('address');
        $gym->lat = $request->request->get('lat');
        $gym->lon = $request->request->get('lon');
        $gym->city = $request->request->get('city');
        $gym->logo = $request->request->get('logo');
        $gym->ranking = $request->request->get('ranking');

        $queryBuilder = $app["db"]->createQueryBuilder()->update('gym', 'g');
        $parametersCount = 0;

        try {
            // Establece los parametros a actualizar.
            if (!is_null($gym->name)) {
                $queryBuilder
                    ->set('g.name', '?')
                    ->setParameter($parametersCount, $gym->name);
                $parametersCount++;
            }
            if (!is_null($gym->address)) {
                $queryBuilder
                    ->set('g.address', "?")
                    ->setParameter($parametersCount, $gym->address);
                $parametersCount++;
            }
            if (!is_null($gym->lat)) {
                $queryBuilder
                    ->set('g.lat', "?")
                    ->setParameter($parametersCount, $gym->lat);
                $parametersCount++;
            }
            if (!is_null($gym->lon)) {
                $queryBuilder
                    ->set('g.lon', "?")
                    ->setParameter($parametersCount, $gym->lon);
                $parametersCount++;
            }
            if (!is_null($gym->city)) {
                $queryBuilder
                    ->set('g.city', "?")
                    ->setParameter($parametersCount, $gym->city);
                $parametersCount++;
            }
            if (!is_null($gym->logo)) {
                $queryBuilder
                    ->set('g.logo', "?")
                    ->setParameter($parametersCount, $gym->logo);
                $parametersCount++;
            }
            if (!is_null($gym->ranking)) {
                $queryBuilder
                    ->set('g.ranking', "?")
                    ->setParameter($parametersCount, $gym->ranking);
                $parametersCount++;
            }

            // Ejecuta el update.
            $queryBuilder->execute();

            return new Response("Ok", 200);
        } catch (\Exception $e) {
            return new Response($e, 300);
        }
        return new Response("Fail", 300);
    }

    /** * Elimina un gimnasio dado su identificador. * @param $id */
    public function delete($id, Application $app)
    {
        $queryBuilder = $app['db']->createQueryBuilder();
        $queryBuilder->delete('gym', 'g')->where($queryBuilder->expr()->eq('g.id', $queryBuilder->createNamedParameter($id)));
    }

    /** * Valida el objeto */
    public function isValid()
    {
        return true;
    }
}
