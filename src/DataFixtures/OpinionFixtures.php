<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class OpinionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $opinion = new Opinion();
            $opinion->setDepositary($this->getReference('user_'.rand(1, 20)));
            $opinion->setEnterprise($this->getReference('etp_'.rand(21, 30)));
            $opinion->setText($faker->text);
            $opinion->setDate($faker->dateTime);
            $opinion->setIsConform(rand(true, false));
            $manager->persist($opinion);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
