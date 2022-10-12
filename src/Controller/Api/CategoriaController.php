<?php

namespace App\Controller\Api;

use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Container\ContainerInterface;

/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository){
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks= true)
     */
    public function getAllCategoria(){
        return $this->categoriaRepository->findAll();
    }
}