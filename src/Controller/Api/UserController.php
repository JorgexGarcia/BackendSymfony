<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
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
    private $logger;
    private $response;

    public function __construct(UserRepository $userRepository, LoggerInterface  $logger){
        $this->userRepository = $userRepository;
        $this->logger = $logger;
        $this->response = new JsonResponse();
    }

    /**
     * @Rest\Post (path="/create")
     * @Rest\View (serializerGroups={"user"},
    serializerEnableMaxDepthChecks=true)
     */
    public function createUser(Request $request,
                               UserPasswordHasherInterface $passwordHasher)
    {
        $user = $request->get('user');
        $rol = $request->get('rol');
        if(!$user || !$rol){
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

        $hashedPassword = $passwordHasher->hashPassword(
            $newuser,
            $user['password']
        );
        $newuser->setPassword($hashedPassword);

        $this->userRepository->add($newuser, true);
        return $newuser;
    }
}