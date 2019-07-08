<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.name LIKE :name')
            ->setParameter('name',$name)
            ->orderBy('t.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getOneOrNullResult();
    }
    public function findAll()
    {
        $queryBuilder = $this->createQueryBuilder('t')
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
