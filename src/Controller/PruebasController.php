<?php

namespace App\Controller;

use Composer\Semver\Interval;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasController extends AbstractController
{
    //contructor para hacer dependencias
    private $logger;
    public function __construct(LoggerInterface  $logger){
        $this->logger = $logger;
    }

    //Para poner rutas, seguido de un nombre
    /**
     * @Route("/get/usuarios", name="get_users")
     */
    public function getAllUser(){
        //Definir el request y el response
        /* Una respuesta
        $response = new Response();
        $response->setContent('<div>Hola Mundo</div>');
        return $response;
        */
        $response = new JsonResponse();
        $response->setData([
           'success'=> true,
           'data'=> [
               [
                   'id'=> 1,
                   'nombre'=> 'Pepe',
                   'email'=> 'pepe@gmail.com'
               ],
               [
                   'id'=> 2,
                   'nombre'=> 'Pepe2',
                   'email'=> 'pepe2@gmail.com'
               ],
               [
                   'id'=> 3,
                   'nombre'=> 'Pepe3',
                   'email'=> 'pepe3@gmail.com'
               ]
           ]
        ]);
        return $response;
    }

    /**
     * @Route("get/one/usuarios", name="get_one_users")
     */
    public function getOneUser(Request $request){
        //Get con parametros en la URL
        $id = $request->get('id');
        //Saber Ip
        //echo $request->getClientIp();

        $this->logger->alert('Visitante con ip: '.$request->getClientIp());
        if($id != null){
            $response = new JsonResponse();
            $response->setData([
                'success'=> true,
                'data'=> [
                    [
                        'id'=> $id,
                        'nombre'=> 'Pepe',
                        'email'=> 'pepe@gmail.com'
                    ]
                ]
            ]);
            return $response;
        }else{
            $response = new Response('No Ok', 400);
            return $response;
        }
    }
}