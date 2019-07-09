<?php


namespace App\Service;


use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class ContactService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addMessege(Contact $contact)
    {
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }
}