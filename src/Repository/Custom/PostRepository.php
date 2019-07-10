<?php

namespace App\Repository\Custom;

use App\Entity\Post;
use App\Repository\Interfaces\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository implements PostRepositoryInterface
{
    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Post::class);
    }

    public function save(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function delete(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
    public function find(int $id): Post
    {
        $post = $this->repository->find($id);
        return $post;
    }

    public function findAll()
    {
        $posts = $this->repository->findAll();
        return $posts;
    }

    public function findAllByPublishedDate()
    {
        return $this->entityManager
            ->createQuery(
                'SELECT p FROM App:Post p ORDER BY p.publishedAt ASC'
            )
            ->getResult();
    }
    public function searchByTitle($title)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title',$title)
            ->orderBy('p.publishedAt', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
    public function findAllPostsIdByTagId($tagId)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.tag_id = :id')
            ->setParameter('id', $tagId)
            ->select('p.post_id')
            ->orderBy('p.post_id', 'ASC')
            ->getQuery();

        return $queryBuilder->getArrayResult();
    }

}
