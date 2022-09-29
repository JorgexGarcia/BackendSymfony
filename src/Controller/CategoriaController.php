<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Cast\Array_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    private $logger;
    private  $resp;
    public function __construct(LoggerInterface  $logger){
        $this->logger = $logger;
        $this->resp = new JsonResponse();
    }

    /**
     * @Route("/categoria", name="create_categoria")
     */
    public function createAction(Request $request, EntityManagerInterface $em){
        $nombreCategoria = $request->get('categoria');

        if(!$nombreCategoria){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' No hay campo nombre Categoría');
            return $this->resp->setData([
               'success' => false,
               'data' => null,
               'error' => 'Categoria controller can´t be null or empty'
            ])->setStatusCode(404);
        }

        $categoria = new Categoria();
        $categoria->setCategoria($nombreCategoria);

        try{
            $em->persist($categoria);
            $em->flush();

            $this->logger->info('Visitante con ip: '.$request->getClientIp()
                .' Guarda '.$categoria->getCategoria().' en la BD');

            return $this->resp->setData([
                'success' => true,
                'data' => [
                    'id' => $categoria->getId(),
                    'categoria' => $categoria->getCategoria()
                ]
            ])->setStatusCode(200);

        }catch (Exception $e){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Error al guardar '.$categoria->getCategoria().' en la BD');
            return $this->resp->setData([
                'success' => false,
                'data' => null,
                'error' => 'Categoria controller can´t be null or empty'
            ])->setStatusCode(500);
        }
    }

    /**
     * @Route ("/categoria/list", name="getAll_categoria")
     */
    public function getAllAction(CategoriaRepository $repo, Request $request){
        try{
            $categoriaList = $repo->findAll();

            if(!$categoriaList){
                $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                    .' No hay campos en Categoría');
                return $this->resp->setData([
                    'success' => false,
                    'data' => null,
                    'error' => 'Categoria is empty'
                ])->setStatusCode(404);
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

            return $this->resp->setData([
                'success' => true,
                'data' => $categoriaAsArray
            ])->setStatusCode(200);

        }catch (Exception $e){
            $this->logger->alert('Visitante con ip: '.$request->getClientIp()
                .' Error al obtener todas las categorias ');
            return $this->resp->setData([
                'success' => false,
                'data' => null,
                'error' => 'Categoria error'
            ])->setStatusCode(500);
        }
    }
}