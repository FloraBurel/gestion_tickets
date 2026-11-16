<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategorieType;
use App\Entity\Categorie;



final class CategoriesController extends AbstractController {
 #[Route('/admin/categories', name: 'app_categories')]
        public function categories(CategorieRepository $categorieRepository): Response
        {
            $categories = $categorieRepository->findAll();
            return $this->render('categories/index.html.twig', [
                'categories' => $categories,
            ]);

            
        }


    #[Route('/admin/categories/{id}/edit', name: 'app_categorie_edit')]
    public function edit(int $id, CategorieRepository $categorieRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = $categorieRepository->find($id);
        
        // Permet de contrôler si la catégorie existe sinon envoi une erreur 
        if (!$categorie) {
        throw $this->createNotFoundException('Categorie introuvable');}

        // Création du formulaire 
        $form = $this->createForm(CategorieType::class,$categorie);

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

        // Redirection vers la liste des categories
        return $this->redirectToRoute('app_categories');
        };

        return $this->render('categories/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    } 
    
    
    
    
    #[Route('/admin/categories/add', name: 'app_categorie_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = new Categorie();
        
        // Création du formulaire 
        $form = $this->createForm(CategorieType::class,$categorie);

        // Récupération des données envoyées
        $form->handleRequest($request);

        // Vérification de l'envoi et de la validité
        if ($form->isSubmitted() && $form->isValid()) {


        // Preparation de l'enregistrement
        $manager->persist($categorie);

        // Enregistrement dans la base
        $manager->flush();

        // Création d'un message de confirmation
        $this->addFlash(
          'success',
          'La catégorie a bien été ajoutée !');

        // Redirection vers la liste des categories
        return $this->redirectToRoute('app_categories');
        };

        return $this->render('categories/add.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
    
    }