<?php

namespace App\Controller\Api;
use App\Repository\CategoriaRepository;
use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/provincias")
 */
class ProvinciasController extends AbstractFOSRestController
{
    private $provinciaRepository;
    private $municipiosRepository;
    private $logger;
    private $response;

    public function __construct(ProvinciasRepository $provinciaRepository,
           MunicipiosRepository $municipiosRepository, LoggerInterface  $logger){
        $this->provinciaRepository = $provinciaRepository;
        $this->municipiosRepository = $municipiosRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"get_provincias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllProvincias(Request $request){

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene todas las provincias de la BD');

        return $this->provinciaRepository->findAll();
    }

    /**
     * @Rest\Get(path="/municipios/{id}")
     * @Rest\View(serializerGroups={"get_provincias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getMuniciposByProvincias(Request $request){


        $provincia = $this->provinciaRepository->find($request->get('id'));

        if(!$provincia) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Provincia '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(404);
        }

        $municipios = $this->municipiosRepository->findBy(['idProvincia'=> $provincia]);

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene los municipios de una provincia '.$request->get('id').' de la BD');

        return $municipios;
    }

}