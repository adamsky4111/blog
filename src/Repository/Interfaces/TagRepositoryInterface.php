<?php

namespace App\Repository\Interfaces;

use App\Entity\Tag;

interface TagRepositoryInterface
{
    //public function findById($id);
    public function find(int $id): Tag;

    public function findAll();
}