<?php

namespace App\Repository\Interfaces;

use App\Entity\User;

interface UserRepositoryInterface
{
    //public function findById($id);
    public function find(int $id): User;

    public function findAll();

    public function findOneByUsername(string $username): User;

    public function save(User $user);

}