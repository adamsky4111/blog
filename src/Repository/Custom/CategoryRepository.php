<?php

namespace App\Repository\Custom;

use App\Entity\Category;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Category::class);
    }

    public function save(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function find(int $id): Category
    {
        $category = $this->repository->find($id);
        return $category;
    }

    public function findAll()
    {
        $categories = $this->repository->findAll();
        return $categories;
    }
}
