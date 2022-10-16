<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/municipios")
 */
class MunicipioController extends AbstractFOSRestController
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
     * @Rest\View(serializerGroups={"municipio"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllMunicipios(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getAllMunicipios');

            return $this->municipiosRepository->findAll();

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getAllMunicipios '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"municipio"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneMunicipio(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getOneMunicipio');

            return $this->municipiosRepository->find($request->get('id'));

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getOneMunicipio '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/provincia/{id}")
     * @Rest\View(serializerGroups={"municipio"}, serializerEnableMaxDepthChecks= true)
     */
    public function getMunicipioByProvincia(Request $request){
        try{

            $provincia = $this->provinciaRepository->find($request->get('id'));
            if(!$provincia) {
                $this->logger->info('Ip: ' . $request->getClientIp()
                    . ' getMunicipioByProvincia Not Found ' . $request->get('id'));
                return $this->response->setData([
                    'success' => false,
                    'data' => null
                ])->setStatusCode(404);
            }

            $municipios = $this->municipiosRepository->findBy(['idProvincia'=> $provincia]);
            $this->logger->info('Ip: '.$request->getClientIp()
                .' getMunicipioByProvincia');

            return $municipios;

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getMunicipioByProvincia '.$exception);

            return $exception;
        }

    }

}