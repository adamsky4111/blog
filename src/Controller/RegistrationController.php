<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Service\RegisterService;
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
    public function register(Request $request, RegisterService $registerService)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registerService->registerUser($user);
        }
        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()]
        );
    }
}