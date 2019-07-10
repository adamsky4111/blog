<?php


namespace App\Service;


use App\Entity\Contact;
use App\Repository\Interfaces\ContactRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContactService
{
    private $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function addMessege(Contact $contact)
    {
        $this->contactRepository->save($contact);
    }
}