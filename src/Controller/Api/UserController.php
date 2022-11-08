<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Entity\User;
use App\Form\ClienteType;
use App\Form\UserType;
use App\Repository\ClienteRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Rest\Route ("/user")
 */
class UserController extends AbstractFOSRestController
{
    private $userRepository;
    private $clienteRepository;
    private $passwordHasher;
    private $logger;
    private $response;

    public function __construct(UserRepository $userRepository,
                                ClienteRepository $clienteRepository,
                                UserPasswordHasherInterface $passwordHasher,
                                LoggerInterface  $logger){
        $this->userRepository = $userRepository;
        $this->clienteRepository = $clienteRepository;
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Post (path="/create")
     * @Rest\View (serializerGroups={"create_user"},serializerEnableMaxDepthChecks=true)
     */
    public function createUser(Request $request)
    {
        $user = $request->get('user');
        $rol = $request->get('rol');
        $cliente = $request->get('cliente');
        if(!$user || !$rol || !$cliente){
            return new Response('Bad Request',
                Response::HTTP_BAD_REQUEST);
        }
        $form = $this->createForm(UserType::class);
        $form->submit($user);
        if(!$form->isValid() || !$form->isSubmitted()){
            return $form;
        }
        /** @var User $newuser */
        $newuser = $form->getData();
        $role[] = $rol;
        $newuser->setRoles($role);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $newuser,
            $user['password']
        );
        $newuser->setPassword($hashedPassword);

        $form = $this->createForm(ClienteType::class);
        $form->submit($cliente);
        if(!$form->isValid() || !$form->isSubmitted()){
            return $form;
        }
        /**
         * @var Cliente $newCliente
         */
        $newCliente = $form->getData();
        $newCliente->setUser($newuser);

        $this->clienteRepository->add($newCliente, true);

        $this->userRepository->add($newuser, true);
        return $newCliente;
    }
}