<?php


namespace App\Service;


use App\Repository\Interfaces\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(User $user, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $password = $userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->userRepository->save($user);
    }

    public function getUserByUsername(string $username)
    {
        return $this->userRepository->findOneByUsername($username);
    }
}