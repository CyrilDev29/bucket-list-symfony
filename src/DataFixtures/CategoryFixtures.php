<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer les 5 catégories demandées
        $categories = [
            'Travel & Adventure',
            'Sport',
            'Entertainment',
            'Human Relations',
            'Others'
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }

        // Sauvegarder tout en base de données
        $manager->flush();
    }
}