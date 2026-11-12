<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur
        $user = new User();

        // Définition de son email
        $user->setEmail('test@example.com');

        // Définition de son rôle
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);

        // Hachage du mot de passe
        $user->setPassword($this->passwordHasher->hashPassword($user,'Tickets2026!')
        );

        // Préparation de l'enregistrement
        $manager->persist($user);


        // Création de catégorie et du tableau des données
        $categories = [
            'Incident',
            'Panne',
            'Evolution',
            'Anomalie',
            'Information',
        ];

        foreach ($categories as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);

            //Préparation à l'enregistrement
            $manager->persist($categorie);
        }

    
         // Création d'état et du tableau des données
        $etats = [
            'Nouveau',
            'Ouvert',
            'Résolu',
            'Fermé',
        ];

        foreach ($etats as $nom) {
            $etat = new Etat();
            $etat->setNom($nom);

            // Préparation à l'enregistrement
            $manager->persist($etat);
        }

  



        // Enregistrement dans la base
        $manager->flush();
    }
}
