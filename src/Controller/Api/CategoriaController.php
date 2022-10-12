<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
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
     * @Rest\View(serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllCategoria(Request $request){

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene todas las categorias de la BD');

        return $this->categoriaRepository->findAll();
    }

    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getOneCategoria(Request $request){

        $categoria = $this->categoriaRepository->find($request->get('id'));

        if(!$categoria) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Categoría '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Obtiene la categoria '.$request->get('id').' de la BD');

        return $categoria;
    }

    /**
     * @Rest\Post(path="/")
     * @Rest\View(serializerGroups={"create_categorias"}, serializerEnableMaxDepthChecks= true)
     */
    public function createCategoria(Request  $request){

        $cat = new Categoria();

        $form = $this->createForm(CategoriaType::class, $cat);

        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Categoría no válida');
            return $form;
        }

        $this->categoriaRepository->add($cat, true);

        return $cat;
    }

    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"create_categorias"}, serializerEnableMaxDepthChecks= true)
     */
    public function updateCategoria(Request  $request){

        $categoria = $this->categoriaRepository->find($request->get('id'));

        if(!$categoria) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Categoría '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => null
            ])->setStatusCode(200);
        }

        $form = $this->createForm(CategoriaType::class,
            $categoria, ['method'=>$request->getMethod()]);

        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Categoría no válida');
            return $form;
        }

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Actualiza la categoria '.$request->get('id').' de la BD');

        $this->categoriaRepository->add($categoria, true);

        return $categoria;
    }

    /**
     * @Rest\Delete(path="/{id}")
     */
    public function deleteCategoria(Request  $request){

        $categoria = $this->categoriaRepository->find($request->get('id'));

        if(!$categoria) {
            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' No hay campos en Categoría '.$request->get('id'));
            return $this->response->setData([
                'success' => true,
                'data' => 'Category not found'
            ])->setStatusCode(404);
        }

        $this->categoriaRepository->remove($categoria,true);

        $this->logger->info('Visitante con ip: '.$request->getClientIp()
            .' Elimina la categoria '.$request->get('id').' de la BD');

        return $this->response->setData([
            'success' => true,
            'data' =>'Category removed'
        ])->setStatusCode(200);
    }
}