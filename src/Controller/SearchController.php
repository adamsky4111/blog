<?php

namespace App\Controller;



use App\Entity\Post;
use App\Entity\Search;
use App\Form\PostType;
use App\Form\SearchType;
use App\Repository\Custom\PostRepository;
use App\Repository\SearchRepository\SearchPostRepository;
use App\Service\Search\PostSearchService;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    /**
     * @Route("/search/")
     *
     * @param Request $request
     * @param RepositoryManagerInterface $manager
     * @return Response
     */
    public function searchByTitle(Request $request,
                                  PostSearchService $searchService): Response
    {
        $search = new Search();
        $form = $this->createForm(
            SearchType::class, $search);

        $form->handleRequest($request);
        if($form->isSubmitted()){

            $result = $searchService->searchByTitle($search->getValue());
            return $this->render('search/index2.html.twig', [
                'result' => $result,
                ]);
        }

        return $this->render('search/index.html.twig', [
            'search' => $search,
            'form' => $form->createView(),
            ]);
    }

    public function showResult(Request $request)
    {

    }
}