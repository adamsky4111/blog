<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/comment/new/{id}", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setPost($post);
            $comment->setCreationDate(new \DateTime("now"));
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $post->getId()
            ]);
        }
        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/comment/new/{id}/new", name="comment_new_self", methods={"GET","POST"})
     */
    public function newSelfComment(Request $request, Comment $parentComment): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setParent($parentComment);
            $comment->setAuthor($this->getUser()->getUsername());
            //$comment->setPost($parentComment->getPost());
            $comment->setCreationDate(new \DateTime("now"));
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $parentComment->getPost()->getId()
            ]);
        }
        return $this->render('comment/_new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


}
