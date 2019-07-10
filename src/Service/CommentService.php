<?php


namespace App\Service;

use App\Repository\Interfaces\CommentRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use App\Entity\Post;

class CommentService
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function AddCommentToPost(Comment $comment,
                                     Post $post,
                                     $username)
    {
        $comment->setAuthor($username);
        $comment->setPost($post);
        $comment->setCreationDate(new \DateTime("now"));
        $this->commentRepository->save($comment);

    }

    public function  AddCommentToComment(Comment $comment,
                                         Comment $parentComment,
                                         $username)
    {
        $comment->setParent($parentComment);
        $comment->setAuthor($username);
        $comment->setCreationDate(new \DateTime("now"));
        $this->commentRepository->save($comment);

    }
}