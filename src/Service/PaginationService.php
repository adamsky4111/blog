<?php

namespace App\Service;

use App\Repository\Interfaces\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class PaginationService
{
    private $postRepository;

    private $paginator;

    public function __construct(PaginatorInterface $paginator, PostRepositoryInterface $postRepository)
    {
        $this->paginator = $paginator;
        $this->postRepository = $postRepository;
    }

    public function paginatePost(Request $request)
    {
        $pagination = $this->paginator->paginate(
            $this->postRepository->paginationPostIndex(), //query
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
        return $pagination;
    }
}
