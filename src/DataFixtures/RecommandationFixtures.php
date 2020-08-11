<?php

namespace App\DataFixtures;

use App\Entity\Recommandation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RecommandationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $recommandation = new Recommandation();
            $recommandation->setLink($faker->url);
            $recommandation->setImage(["$faker->word . $faker->fileExtension"]);
            $recommandation->setEnterprise($this->getReference('etp_'.rand(21, 30)));
        }
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
