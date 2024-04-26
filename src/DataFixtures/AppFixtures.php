<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Type;
use App\Entity\Section;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $this->loadSection($manager);
        $this->loadType($manager);
    }

    public function loadSection(ObjectManager $manager): void
    {
        // Liste d'équipements
        $sectionList = [
            'Arts Appliqués',
            'Design Graphique & Digital',
            'Développement Web & Informatique',
            'Audiovisuel',
            'Animation 2D/3D',
            'Métiers du Son & MAO',
        ];

        foreach ($sectionList as $sectionName) {
            $section = new Section();
            $section->setLabel($sectionName);

            $manager->persist($section);
        }

        $manager->flush();
    }

    public function loadType(ObjectManager $manager): void
    {
        // Liste de types de bien
        $propertyTypes = [
            'Projet d\'Arts',
            'Projet Design',
            'Projet Développement web',
            'Projet Audiovisuel',
            'Projet Animation',
            'Projet Métiers du Son',
        ];

        foreach ($propertyTypes as $typeName) {
            $propertyType = new Type();
            $propertyType->setLabel($typeName);

            $manager->persist($propertyType);
        }

        $manager->flush();
    }
}