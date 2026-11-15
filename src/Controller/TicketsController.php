<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TicketsRepository;

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
}
