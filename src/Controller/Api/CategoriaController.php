<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{
    private $categoriaRepository;
    private $logger;
    private $response;

    public function __construct(CategoriaRepository $categoriaRepository, LoggerInterface  $logger){
        $this->categoriaRepository = $categoriaRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllCategoria(Request $request){

        try{

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getAllCategoria');

            return $this->categoriaRepository->findAll();

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getAllCategoria '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneCategoria(Request $request){

        try{

            $categoria = $this->categoriaRepository->find($request->get('id'));

            if(!$categoria) {
                $this->logger->info('Ip: ' . $request->getClientIp()
                    . ' getOneCategoria Not Found ' . $request->get('id'));
                return $this->response->setData([
                    'success' => false,
                    'data' => null
                ])->setStatusCode(404);
            }

            $this->logger->info('Ip: '.$request->getClientIp()
                .' getOneCategoria');

            return $categoria;

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error getOneCategoria '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Post(path="/admin")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function createCategoria(Request  $request){
        try{

            $cat = new Categoria();

            $form = $this->createForm(CategoriaType::class, $cat);

            $form->handleRequest($request);

            if(!$form->isSubmitted() || !$form->isValid()){
                $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                    .' createCategoria');
                return $form;
            }

            $this->categoriaRepository->add($cat, true);

            return $cat;

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error createCategoria '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Patch(path="/admin/{id}")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function updateCategoria(Request  $request){

        try{

            $categoria = $this->categoriaRepository->find($request->get('id'));

            if(!$categoria) {
                $this->logger->info('Ip: ' . $request->getClientIp()
                    . ' updateCategoria Not Found ' . $request->get('id'));
                return $this->response->setData([
                    'success' => false,
                    'data' => null
                ])->setStatusCode(404);
            }

            $form = $this->createForm(CategoriaType::class,
                $categoria, ['method'=>$request->getMethod()]);

            $form->handleRequest($request);

            if(!$form->isSubmitted() || !$form->isValid()){
                $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                    .' updateCategoria');
                return $form;
            }

            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' updateCategoria');

            $this->categoriaRepository->add($categoria, true);

            return $categoria;

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error updateCategoria '.$exception);

            return $exception;
        }
    }

    /**
     * @Rest\Delete(path="/admin/{id}")
     */
    public function deleteCategoria(Request  $request){

        try{

            $categoria = $this->categoriaRepository->find($request->get('id'));

            if(!$categoria) {
                $this->logger->info('Ip: ' . $request->getClientIp()
                    . ' deleteCategoria Not Found ' . $request->get('id'));
                return $this->response->setData([
                    'success' => false,
                    'data' => null
                ])->setStatusCode(404);
            }

            $this->categoriaRepository->remove($categoria,true);

            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' deleteCategoria');

            return $this->response->setData([
                'success' => true,
                'data' =>'Category removed'
            ])->setStatusCode(200);

        }catch (Exception $exception){

            $this->logger->alert('Ip: '.$request->getClientIp()
                .' Error deleteCategoria '.$exception);

            return $exception;
        }
    }
}