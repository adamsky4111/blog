<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Repository\CommentRepository;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact", methods={"GET","POST"})
     */
    public function new(Request $request,
                        ContactService $contactService): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactService->addMessege($contact);

            return $this->redirectToRoute('post_index');
        }
        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}