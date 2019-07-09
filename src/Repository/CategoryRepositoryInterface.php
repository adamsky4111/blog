<?php

namespace App\Repository;

interface CategoryRepositoryInterface
{
    public function findById($id);
    public function save(\App\Entity\Category $category);
}