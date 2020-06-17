<?php

namespace App\DataFixtures;

use App\Entity\ExpertArgumentation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExpertArgumentations extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=1; $i<=10; $i++) {
            $arg = new ExpertArgumentation();
            $rand = rand(0, 1);
            if ($rand === 1) {
                $arg->setOdd($this->getReference('odd_'.rand(1, 17)));
            } else {
                $arg->setRse($this->getReference('rse_type'.rand(1, 20)));
            }
            $arg->setDepositary($this->getReference('expert_'.rand(11, 20)));
            $arg->setDate($faker->dateTime);
            $arg->setText($faker->text);
            $arg->setIllustration("illustration.$faker->fileExtension");
            $arg->setLinks(["link.$faker->fileExtension","link.$faker->fileExtension"]);
            $arg->setKeywords(["keyword1"]);
            $manager->persist($arg);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [OddFixtures::class,RseCriteriaFixtures::class,UserFixtures::class];
    }
}
