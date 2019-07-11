<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tag;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\Interfaces\PostRepositoryInterface;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\DuplicateService;
use App\Service\FileUploaderService;
use App\Service\PaginationService;
use App\Service\PostService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @Route("/home")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PaginationService $paginationService,
                          Request $request): Response
    {
        return $this->render('post/index.html.twig', [
            'pagination' => $paginationService->paginatePost($request),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        PostService $postService): Response
    {
        $post = new Post();
        $post->addTag(new Tag());
        $form = $this->createForm(
            PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $postService->addOrUpdatePost($post,
                $this->getParameter('img_directory'));

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET", "POST"})
     */
    public function show(Post $post): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}/", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,
                         Post $post,
                         PostService $postService): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postService->addOrUpdatePost($post,
                $this->getParameter('img_directory'));

            return $this->redirectToRoute('post_index', [
                'id' => $post->getId(),
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request,
                           Post $post, PostService $postService): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(),
                $request->request->get('_token'))) {
            $postService->deletePost($post);
        }

        return $this->redirectToRoute('post_index');
    }
}
