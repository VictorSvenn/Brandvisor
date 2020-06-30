<?php

namespace App\DataFixtures;

use App\Entity\Initiative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class InitiativesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $initiative = new Initiative();
            $initiative->setDepositary($this->getReference('user_'.rand(1, 20)));
            $initiative->setName($faker->word);
            $initiative->setIllustration("illustration.$faker->fileExtension");
            $initiative->setPresentation($faker->text);
            $initiative->setObjective($faker->text);
            $initiative->setDetailledDescription($faker->text);
            $initiative->setPartner("partner1", "partner2");
            $initiative->setLinks('link1 link2');
            $initiative->setWebsite($faker->url);
            $initiative->setGeographicArea($faker->city);
            $initiative->setKeywords("keyword1", "keyword2");
            $initiative->setIsConform(rand(true, false));
            $initiative->addLike($this->getReference('consumer_'.rand(1, 10)));
            $initiative->addOdd($this->getReference('odd_'.rand(1, 17)));
            $manager->persist($initiative);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [OddFixtures::class, UserFixtures::class];
    }
}
