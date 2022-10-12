<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use http\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/cliente")
 */
class ClienteController extends AbstractFOSRestController
{
    private $clienteRepository;
    private $logger;
    private $response;

    public function __construct(ClienteRepository $clienteRepository, LoggerInterface  $logger){
        $this->clienteRepository = $clienteRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Post(path="/")
     * @Rest\View(serializerGroups={"create_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function createCliente(Request $request){
        try{
            $cliente = new Cliente();

            $form = $this->createForm(ClienteType::class, $cliente);

            $form->handleRequest($request);

            if(!$form->isSubmitted() || !$form->isValid()){
                $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                    .' Cliente no válido');
                return $form;
            }

            $this->clienteRepository->add($cliente, true);

            return $cliente;

        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"get_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneCliente(Request $request){

        $cliente = $this->clienteRepository->find($request->get('id'));

        if(!$cliente) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Cliente '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene el cliente '.$request->get('id').' de la BD');

        return $cliente;
    }

    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"create_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function updateCliente(Request  $request){

        $cliente = $this->clienteRepository->find($request->get('id'));

        if(!$cliente) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Cliente '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $form = $this->createForm(ClienteType::class,
            $cliente, ['method'=>$request->getMethod()]);

        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Cliente no válido');
            return $form;
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Actualiza el cliente '.$request->get('id').' de la BD');

        $this->clienteRepository->add($cliente, true);

        return $cliente;
    }
}