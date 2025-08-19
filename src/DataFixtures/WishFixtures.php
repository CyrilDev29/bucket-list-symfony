<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer 5 souhaits simples d'abord (sans Faker)
        $wishesData = [
            [
                'title' => 'Visiter le Japon',
                'description' => 'Découvrir la culture japonaise, goûter la cuisine locale et voir les cerisiers en fleurs.',
                'author' => 'Marie',
                'isPublished' => true
            ],
            [
                'title' => 'Apprendre la guitare',
                'description' => 'Maîtriser cet instrument et pouvoir jouer mes chansons préférées.',
                'author' => 'Pierre',
                'isPublished' => true
            ],
            [
                'title' => 'Faire un marathon',
                'description' => 'Courir 42 kilomètres et repousser mes limites physiques.',
                'author' => 'Julie',
                'isPublished' => true
            ],
            [
                'title' => 'Écrire un livre',
                'description' => 'Publier mon premier roman et partager mes histoires.',
                'author' => 'Thomas',
                'isPublished' => false
            ],
            [
                'title' => 'Voyager en Islande',
                'description' => 'Voir les aurores boréales et les paysages volcaniques uniques.',
                'author' => 'Sophie',
                'isPublished' => true
            ]
        ];

        foreach ($wishesData as $data) {
            $wish = new Wish();
            $wish->setTitle($data['title']);
            $wish->setDescription($data['description']);
            $wish->setAuthor($data['author']);
            $wish->setIsPublished($data['isPublished']);

            // Ajouter explicitement les dates
            $wish->setDateCreated(new \DateTime());

            $manager->persist($wish);
        }

        $manager->flush();
    }
}