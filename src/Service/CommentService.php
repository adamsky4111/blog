<?php


namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use App\Entity\Post;

class CommentService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function AddCommentToPost(Comment $comment,
                                     Post $post,
                                     $username)
    {
        $comment->setAuthor($username);
        $comment->setPost($post);
        $comment->setCreationDate(new \DateTime("now"));
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

    }

    public function  AddCommentToComment(Comment $comment,
                                         Comment $parentComment,
                                         $username)
    {
        $comment->setParent($parentComment);
        $comment->setAuthor($username);
        $comment->setCreationDate(new \DateTime("now"));
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

    }
}