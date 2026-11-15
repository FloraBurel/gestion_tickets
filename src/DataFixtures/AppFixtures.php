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
        // Création d'un administrateur
        $admin = new User();

        // Définition de son email
        $admin->setEmail('admin@example.com');

        // Définition de son rôle
        $admin->setRoles(['ROLE_USER','ROLE_ADMIN']);

        // Hachage du mot de passe
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'Admin2026!')
        );

        // Préparation de l'enregistrement
        $manager->persist($admin);


        // Création d'un personnel
        $personnel = new User();

        // Définition de son email
        $personnel->setEmail('personnel@example.com');

        // Définition de son rôle
        $personnel->setRoles(['ROLE_USER','ROLE_PERSONNEL']);

        // Hachage du mot de passe
        $personnel->setPassword($this->passwordHasher->hashPassword($personnel,'Personnel2026!')
        );

        // Préparation de l'enregistrement
        $manager->persist($personnel);


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
