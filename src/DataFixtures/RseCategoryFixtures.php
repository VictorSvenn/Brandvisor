<?php

namespace App\DataFixtures;

use App\Entity\RseCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RseCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $rse = [
            'Gouvernance',
            'Social',
            'Environnement',
            'Loyauté des pratiques',
            'Consommateurs',
            'Communautés et développement local',

        ];
        $tmp = 0;
        foreach ($rse as $value) {
            $a = new RseCategory();
            $a->setName($value);
            $this->addReference('rse_' . $tmp, $a);
            $manager->persist($a);
            $manager->flush();
            $tmp++;
        }
    }
}
