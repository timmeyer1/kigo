<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sections = [
            ['label' => 'Arts Appliqués'],
            ['label' => 'Design Graphique & Digital'],
            ['label' => 'Développement Web & Informatique'],
            ['label' => 'Audiovisuel'],
            ['label' => 'Animation 2D/3D'],
            ['label' => 'Métiers du Son & MAO'],
        ];

        foreach ($sections as $sectionData) {
            $section = new Section();
            $section->setLabel($sectionData['label']);
            $manager->persist($section);
        }

        $manager->flush();
    }
}