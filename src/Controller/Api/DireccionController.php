<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\ClienteRepository;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/direccion")
 */
class DireccionController extends AbstractFOSRestController
{
    private $direccionRepository;
    private $clienteRepository;
    private $logger;
    private $response;

    public function __construct(DireccionRepository $direccionRepository,ClienteRepository $clienteRepository,
                                LoggerInterface  $logger){
        $this->direccionRepository = $direccionRepository;
        $this->clienteRepository = $clienteRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Post(path="/")
     * @Rest\View(serializerGroups={"create_direccion"}, serializerEnableMaxDepthChecks= true)
     */
    public function createDireccion(Request $request){
        try{
            $direccion = new Direccion();

            $form = $this->createForm(DireccionType::class, $direccion);

            $form->handleRequest($request);

            if(!$form->isSubmitted() || !$form->isValid()){
                $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                    .' Direccion no válida');
                return $form;
            }

            $this->direccionRepository->add($direccion, true);

            return $direccion;

        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"get_direccion"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneDireccion(Request $request){

        $direccion = $this->direccionRepository->find($request->get('id'));

        if(!$direccion) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Direccion '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene la direccion '.$request->get('id').' de la BD');

        return $direccion;
    }

    /**
     * @Rest\Get(path="/cliente/{id}")
     * @Rest\View(serializerGroups={"get_direccion"}, serializerEnableMaxDepthChecks= true)
     */
    public function getDireccionCliente(Request $request){

        $cliente = $this->clienteRepository->find($request->get('id'));

        if(!$cliente) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Cliente '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(404);
        }

        $direcciones = $this->direccionRepository->findBy(['cliente'=> $cliente]);

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene las direcciones del cliente '.$request->get('id').' de la BD');

        return $direcciones;
    }

    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"create_direccion"}, serializerEnableMaxDepthChecks= true)
     */
    public function updateDireccion(Request  $request){

        $direccion = $this->direccionRepository->find($request->get('id'));

        if(!$direccion) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en la Direccion '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $form = $this->createForm(DireccionType::class,
            $direccion, ['method'=>$request->getMethod()]);

        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Direccion no válida');
            return $form;
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Actualiza la direccion '.$request->get('id').' de la BD');

        $this->direccionRepository->add($direccion, true);

        return $direccion;
    }

    /**
     * @Rest\Delete(path="/{id}")
     */
    public function deleteDireccion(Request  $request){

        $direccion = $this->direccionRepository->find($request->get('id'));

        if(!$direccion) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Direccion '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => 'Category not found'
            ])->setStatusCode(404);
        }

        $this->direccionRepository->remove($direccion,true);

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Elimina la Direccion '.$request->get('id').' de la BD');

        return $this->response->setData([
            'success' => true,
            'data' =>'Category removed'
        ])->setStatusCode(200);
    }
}