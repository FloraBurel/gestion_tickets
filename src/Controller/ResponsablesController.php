<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ResponsableRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResponsableType;
use App\Entity\Responsable;



final class ResponsablesController extends AbstractController {
 #[Route('/admin/responsables', name: 'app_responsables')]
        public function responsables(ResponsableRepository $responsableRepository): Response
        {
            $responsables = $responsableRepository->findAll();
            return $this->render('responsables/index.html.twig', [
                'responsables' => $responsables,
            ]);

            
        }


    #[Route('/admin/responsables/{id}/edit', name: 'app_responsable_edit')]
    public function edit(int $id, ResponsableRepository $responsableRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $responsable = $responsableRepository->find($id);
        
        // Permet de contrôler si le reseponsable existe sinon envoi une erreur 
        if (!$responsable) {
        throw $this->createNotFoundException('Responsable introuvable');}

        // Création du formulaire 
        $form = $this->createForm(ResponsableType::class,$responsable);

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

        // Redirection vers la liste des responsables
        return $this->redirectToRoute('app_responsables');
        };

        return $this->render('responsables/edit.html.twig', [
            'responsable' => $responsable,
            'form' => $form->createView(),
        ]);
    } 
    
    
    
    
    #[Route('/admin/responsables/add', name: 'app_responsable_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $responsable = new Responsable();
        
        // Création du formulaire 
        $form = $this->createForm(ResponsableType::class,$responsable);

        // Récupération des données envoyées
        $form->handleRequest($request);

        // Vérification de l'envoi et de la validité
        if ($form->isSubmitted() && $form->isValid()) {


        // Preparation de l'enregistrement
        $manager->persist($responsable);

        // Enregistrement dans la base
        $manager->flush();

        // Création d'un message de confirmation
        $this->addFlash(
          'success',
          'Le responsable a bien été ajouté !');

        // Redirection vers la liste des responsables
        return $this->redirectToRoute('app_responsables');
        };

        return $this->render('responsables/add.html.twig', [
            'responsable' => $responsable,
            'form' => $form->createView(),
        ]);
    }
    
    }