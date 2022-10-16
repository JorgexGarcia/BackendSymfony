<?php

namespace App\Controller\Api;

use App\Repository\AlergenoRepository;
use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/alergenos")
 */
class AlergenoController extends AbstractFOSRestController
{
    private $alergenoRepository;
    private $logger;
    private $response;

    public function __construct(AlergenoRepository $alergenoRepository,
                                LoggerInterface  $logger){
        $this->alergenoRepository = $alergenoRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"alergeno"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllAlergenos(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getAllAlergenos');

            return $this->alergenoRepository->findAll();

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getAllAlergenos '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"alergeno"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneAlergeno(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getOneAlergeno');

            return $this->alergenoRepository->find($request->get('id'));

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getOneAlergeno '.$exception);

            return $exception;
        }
    }

}