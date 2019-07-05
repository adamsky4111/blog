<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\SearchType;
use App\Form\TagType;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    public function searchByTitle(Request $request, PostRepository $postRepository): Response
    {

    }

}