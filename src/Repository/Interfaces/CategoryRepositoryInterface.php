<?php

namespace App\Repository\Interfaces;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    //public function findById($id);
    public function save(Category $category): void;

    public function find(int $id): Category;

    public function findAll();
}