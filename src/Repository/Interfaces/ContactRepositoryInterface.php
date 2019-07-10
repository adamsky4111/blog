<?php

namespace App\Repository\Interfaces;

use App\Entity\Contact;

interface ContactRepositoryInterface
{
    //public function findById($id);
    public function save(Contact $contact): void;

    public function find(int $id): Contact;

    public function findAll();
}