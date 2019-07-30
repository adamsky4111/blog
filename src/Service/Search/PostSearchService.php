<?php


namespace App\Service\Search;


use App\Entity\Post;
use App\Repository\SearchRepository\SearchPostRepository;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;

class PostSearchService
{
    private $manager;

    public function __construct(RepositoryManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function searchByTitle($search)
    {
        /** @var SearchPostRepository $repository */
        $repository = $this->manager->getRepository(Post::class);

        return $repository->search($search);
    }
}