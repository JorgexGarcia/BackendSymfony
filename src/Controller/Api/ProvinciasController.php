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
     * @Rest\View(serializerGroups={"provincias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllProvincias(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getAllProvincias');

            return $this->provinciaRepository->findAll();

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getAllProvincias '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"provincias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneProvincia(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getOneProvincia');

            return $this->provinciaRepository->find($request->get('id'));

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getOneProvincia '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/municipio/{id}")
     * @Rest\View(serializerGroups={"provincias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getProvinciaByMunicipio(Request $request){
        try{

            $municipio = $this->municipiosRepository->find($request->get('id'));

            if(!$municipio) {
                $this->logger->info('Ip: '.$request->getClientIp()
                    .' getProvinciaByMunicipio Not Found '.$request->get('id'));
                return $this->response->setData([
                    'success' => false,
                    'data' => null
                ])->setStatusCode(404);
            }

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getProvinciaByMunicipio');

            return $this->provinciaRepository->findBy(['id'=> $municipio->getIdProvincia()]);

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getProvinciaByMunicipio '.$exception);

            return $exception;
        }

//        $provincia = $this->provinciaRepository->find($request->get('id'));
//
//        if(!$provincia) {
//            $this->logger->info('Visitante con ip: '.$request->getClientIp()
//                .' No hay campos en Provincia '.$request->get('id'));
//            return $this->response->setData([
//                'success' => true,
//                'data' => null
//            ])->setStatusCode(404);
//        }
//
//        $municipios = $this->municipiosRepository->findBy(['idProvincia'=> $provincia]);
//
//        $this->logger->info('Visitante con ip: '.$request->getClientIp()
//            .' Obtiene los municipios de una provincia '.$request->get('id').' de la BD');
//
//        return $municipios;
    }

}