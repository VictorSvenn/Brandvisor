<?php

namespace App\DataFixtures;

use App\Entity\Challenge;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $challenge = new Challenge();
            $rand = rand(0, 1);
            if ($rand===1) {
                $challenge->setEngagement($this->getReference('engagement_'.rand(1, 10)));
            } else {
                $challenge->setEnterprise($this->getReference('etp_'.rand(21, 30)));
            }
            $challenge->setDepositary($this->getReference('user_'.rand(1, 10)));
            $challenge->setName($faker->word);
            $challenge->setDescription($faker->text);
            $challenge->setComment($faker->text);
            $challenge->setIsConform(rand(true, false));
            $rand = rand(0,4);
            for ($o=1;$o<=$rand;$o++){
                $challenge->addLike($this->getReference('consumer_'.rand(1,10)));
            }
            $challenge->setDocuments(["document$i.$faker->fileExtension","document$i.$faker->fileExtension"]);
            $manager->persist($challenge);
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [UserFixtures::class, EngagementFixtures::class];
    }
}
