<?php

namespace App\Repository\Custom;

use App\Entity\Contact;
use App\Repository\Interfaces\ContactRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Contact::class);
    }

    public function save(Contact $contact): void
    {
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function find(int $id): Contact
    {
        return $this->repository->find($id);
    }

}
