<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class RegisterService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function registerUser(User $user, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $password = $userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}