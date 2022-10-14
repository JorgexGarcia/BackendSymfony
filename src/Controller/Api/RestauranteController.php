<?php

namespace App\Controller\Api;

use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
    private $restauranteRepository;
    private $logger;
    private $response;

    public function __construct(RestauranteRepository $restauranteRepository, LoggerInterface  $logger){
        $this->restauranteRepository = $restauranteRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurante(Request $request){
        return $this->restauranteRepository->find($request->get('id'));
    }

    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"filtered"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurantesByFiltered(Request $request){

        $dia = $request->get('dia');
        $hora = $request->get('hora');
        $idMunicipio = $request->get('municipio');

        //Comprobar que vienen esos datos, si no viene alguno ->BAD REQUEST
        $restaurantes = $this->restauranteRepository->findByDayTimeMunicipio($dia,$hora,$idMunicipio);
        return $restaurantes;

    }
}