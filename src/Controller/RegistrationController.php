<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Service\RegisterService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register_user")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             UserService $userService)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->registerUser($user, $passwordEncoder);
        }
        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()]
        );
    }
}