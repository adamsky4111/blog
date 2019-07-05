<?php
namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }
    public function findAllOrderedByCreatedDate()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:Post p ORDER BY p.creationDate ASC'
            )
            ->getResult();
    }
    public function searchByTitle($title)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title',$title)
            ->orderBy('p.creationDate', 'ASC')
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
