<?php


namespace App\Service;

use App\Repository\Interfaces\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use App\Entity\Post;

class CategoryService
{
    private $entityManager;

    private $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, CategoryRepositoryInterface $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }
}