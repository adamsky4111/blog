<?php

namespace App\Repository\Interfaces;

use App\Entity\Post;

interface PostRepositoryInterface
{
    //public function findById($id);
    public function save(Post $post): void;

    public function delete(Post $post): void;

    public function find(int $id): Post;

    public function findAll();

    public function findAllByPublishedDate();
}