<?php

namespace App\Repository\Interfaces;

use App\Entity\Comment;

interface CommentRepositoryInterface
{
    //public function findById($id);
    public function save(Comment $comment): void;

    public function find(int $id): Comment;

    public function findAll();
}