<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tag::class);
    }
    public function containsNameGetOneOrNull($name)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :name')
            ->setParameter('name',$name)
            ->orderBy('p.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getOneOrNullResult();
    }
    public function findAll()
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p.name')
            ->orderBy('p.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
    public function findAllTagsIdByPostId($postId)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.post_id = :name')
            ->setParameter('postId', $postId)
            ->select('p.tag_id')
            ->orderBy('p.tag_id', 'ASC')
            ->getQuery();

        return $queryBuilder->getArrayResult();
    }
}
