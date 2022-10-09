<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{

    private $logger;
    private  $response;
    private $repository;
    public function __construct(LoggerInterface  $logger, CategoriaRepository $repository){
        $this->logger = $logger;
        $this->response = new JsonResponse();
        $this->repository = $repository;
    }

    /**
     * @Route("/categoria", name="create_categoria")
     */
    public function createCategoriaAction(Request $request, EntityManagerInterface $em){
        //1º Coger el elemento
        $nombreCategoria = $request->get('categoria');
        //2º Comprobar si tiene
        if(!$nombreCategoria){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' No hay campo nombre Categoría');
            return $this->response->setData([
                'success' => false,
                'data' => null,
                'error' => 'Categoria controller can´t be null or empty'
            ])->setStatusCode(404);
        }
        //3º Crear un objeto
        $categoria = new Categoria();
        $categoria -> setCategoria($nombreCategoria);
        //4º Guardar en BD
        try{
            $em->persist($categoria);
            $em->flush();

            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' Guarda '.$categoria->getCategoria().' en la BD');

            return $this->response->setData([
                'success' => true,
                'data' => [
                    'id' => $categoria->getId(),
                    'categoria' => $categoria->getCategoria()
                ]
            ])->setStatusCode(200);

        }catch (Exception $e){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Error al guardar '.$categoria->getCategoria().' en la BD');
            return $this->response->setData([
                'success' => false,
                'data' => null,
                'error' => 'Error saving to database'
            ])->setStatusCode(500);
        }
    }

    /**
     * @Route ("/categoria/list", name="getAll_categoria")
     */
    public function getAllAction(Request $request){
        try{
            $categoriaList = $this->repository->findAll();

            if(!$categoriaList){
                $this->logger->info('Visitante con ip: '.$request->getClientIp()
                    .' No hay campos en Categoría');
                return $this->response->setData([
                    'success' => true,
                    'data' => null
                ])->setStatusCode(200);
            }

            $categoriaAsArray = [];
            foreach ($categoriaList as $cat){
                $categoriaAsArray[]= [
                    'id' => $cat->getId(),
                    'categoria' => $cat->getCategoria()
                ];
            }

            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' Obtiene todas las categorias de la BD');

            return $this->response->setData([
                'success' => true,
                'data' => $categoriaAsArray
            ])->setStatusCode(200);

        }catch (Exception $e){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Error al obtener todas las categorias ');
            return $this->response->setData([
                'success' => false,
                'data' => null,
                'error' => 'Error connecting to database'
            ])->setStatusCode(500);
        }
    }
}