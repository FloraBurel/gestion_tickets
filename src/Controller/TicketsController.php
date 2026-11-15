<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TicketsRepository;
use App\Form\TicketsPersonnelType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class TicketsController extends AbstractController
{
    #[Route('/tickets', name: 'app_tickets')]
    public function index(TicketsRepository $ticketsRepository): Response
    {
        $tickets = $ticketsRepository->findAll();
        return $this->render('tickets/index.html.twig', [
            'tickets' => $tickets,
        ]);

        
    }

    #[Route('/tickets/{id}/edit', name: 'app_ticket_edit')]
    public function edit(int $id, TicketsRepository $ticketsRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $ticket = $ticketsRepository->find($id);

        // Permet de contrôler si le ticket existe sinon envoi une erreur 
        if (!$ticket) {
        throw $this->createNotFoundException('Ticket introuvable');}

        // Création du formualaire 
        $form = $this->createForm(TicketsPersonnelType::class,$ticket);

        // Récupération des données envoyées
        $form->handleRequest($request);

        // Vérification de l'envoi et de la validité
        if ($form->isSubmitted() && $form->isValid()) {

        // Enregistrement dans la base
        $manager->flush();

        // Création d'un message de confirmation
        $this->addFlash(
          'success',
          'Les données ont bien été modifiées!');

        // Redirection vers la liste de tickets
        return $this->redirectToRoute('app_tickets');
        } 
        
       
        

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
