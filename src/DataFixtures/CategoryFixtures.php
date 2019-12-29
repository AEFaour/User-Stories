<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createCategory("Emploi", 1));
        $manager->persist($this->createCategory("Vacances", 2));
        $manager->persist($this->createCategory("Mode", 3));
        $manager->persist($this->createCategory("Maison", 4));
        $manager->persist($this->createCategory("Véhicules", 5));
        $manager->persist($this->createCategory("Loisirs", 6));
        $manager->persist($this->createCategory("Multimédia", 7));
        $manager->persist($this->createCategory("Professionnel", 8));
        $manager->persist($this->createCategory("Immobilier", 9));
        $manager->persist($this->createCategory("Services", 10));

        $manager->flush();
    }

    private function createCategory($kind, $order){
        $category = new Category();
        $category->setCategory($kind);
        $this->addReference("category_$order", $category);
        return $category;

    }
}
