<?php

namespace App\Controller;



use App\Entity\Post;
use App\Entity\Search;
use App\Form\PostType;
use App\Form\SearchType;
use App\Repository\Custom\PostRepository;
use App\Repository\SearchRepository\SearchPostRepository;
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
     * @param PostRepository $postRepository
     * @return Response
     */
    public function searchByTitle(Request $request,
                                  RepositoryManagerInterface $manager, PostRepository $postRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(
            SearchType::class, $search);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            /** @var SearchPostRepository $repository */
            $repository = $manager->getRepository(Post::class);
            dd($repository->search($search->getValue()));

        }

        return $this->render('search/index.html.twig', [
            'search' => $search,
            'form' => $form->createView(),]);
    }

}