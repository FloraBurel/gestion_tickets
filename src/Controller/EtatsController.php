<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EtatRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EtatType;
use App\Entity\Etat;



final class EtatsController extends AbstractController {
 #[Route('/admin/etats', name: 'app_etats')]
        public function etats(EtatRepository $etatRepository): Response
        {
            $etats = $etatRepository->findAll();
            return $this->render('etats/index.html.twig', [
                'etats' => $etats,
            ]);

            
        }


    #[Route('/admin/etats/{id}/edit', name: 'app_etat_edit')]
    public function edit(int $id, EtatRepository $etatRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $etat = $etatRepository->find($id);
        
        // Permet de contrôler si l'état existe sinon envoi une erreur 
        if (!$etat) {
        throw $this->createNotFoundException('Etat introuvable');}

        // Création du formulaire 
        $form = $this->createForm(EtatType::class,$etat);

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

        // Redirection vers la liste des états
        return $this->redirectToRoute('app_etats');
        };

        return $this->render('etats/edit.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
    } 
    
    
    
    
    #[Route('/admin/etats/add', name: 'app_etat_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $etat = new Etat();
        
        // Création du formulaire 
        $form = $this->createForm(EtatType::class,$etat);

        // Récupération des données envoyées
        $form->handleRequest($request);

        // Vérification de l'envoi et de la validité
        if ($form->isSubmitted() && $form->isValid()) {


        // Preparation de l'enregistrement
        $manager->persist($etat);

        // Enregistrement dans la base
        $manager->flush();

        // Création d'un message de confirmation
        $this->addFlash(
          'success',
          'L\'état a bien été ajouté !');

        // Redirection vers la liste des états
        return $this->redirectToRoute('app_etats');
        };

        return $this->render('etats/add.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
    }
    
    }