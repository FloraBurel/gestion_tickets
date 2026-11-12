<?php

namespace App\Controller;

use App\Form\TicketsPublicType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
Use App\Repository\EtatRepository;



final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request, EtatRepository $etatRepository, EntityManagerInterface $manager): Response
    {
        // Création du formulaire
        $form = $this->createForm(TicketsPublicType::class);

        // Récupération des données envoyées
        $form->handleRequest($request);
      
        // Vérification de l'envoi et de la validité
        if ($form->isSubmitted() && $form->isValid()) {

        // Récupération des valeurs
        $data = $form->getData();

        // Attribution de la date automatiquement
        $data->setDateOuverture(new \DateTimeImmutable());

        // Recherche l'état 'Nouveau'
        $etat = $etatRepository->findOneBy(['nom' => 'Nouveau']);

        // Attribut l'état 'Nouveau'
        $data->setEtat($etat);

        // Préparation de l'enregistrement
        $manager->persist($data);
        
        // Enregistrement dans la base
        $manager->flush();

        // Création d'un message de confirmation
        $this->addFlash(
            'success',
            'Votre tickets a bien été envoyé !'
        );   
        
        
    // Redirection vers le formulaire
        return $this->redirectToRoute('app_accueil');
 }

        
        return $this->render('accueil/index.html.twig', [
            'form' => $form,
        ]); 
        
        
}}


       