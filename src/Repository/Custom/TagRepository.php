<?php

namespace App\Repository\Custom;

use App\Entity\Tag;
use App\Repository\Interfaces\TagRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TagRepository implements TagRepositoryInterface
{
    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Tag::class);
    }

    public function find(int $id): Tag
    {
        return $this->repository->find($id);
    }



    public function containsNameGetOneOrNull($name)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.name LIKE :name')
            ->setParameter('name',$name)
            ->orderBy('t.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getOneOrNullResult();
    }
    public function findAll()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder('t')
            //->select('t.name')
            ->orderBy('t.name', 'ASC')
            ->getQuery();

        return new ArrayCollection($queryBuilder->getResult());
    }
    public function findAllTagsIdByPostId($postId)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.post_id = :name')
            ->setParameter('postId', $postId)
            ->select('t.tag_id')
            ->orderBy('t.tag_id', 'ASC')
            ->getQuery();

        return $queryBuilder->getArrayResult();
    }
}
