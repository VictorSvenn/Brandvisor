<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Engagement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EngagementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $engagement = new Engagement();
            $engagement->setOwner($this->getReference('etp_'.rand(21, 30)));
            $engagement->setName($faker->word);
            $engagement->setActionText($faker->text);
            $engagement->setActionDocuments(["actiondocument$i.$faker->fileExtension",
                "actiondocument$i.$faker->fileExtension"]);
            $engagement->setResultsText($faker->text);
            $engagement->setResultsDocuments(["resultdocument$i.$faker->fileExtension",
                "resultdocument$i.$faker->fileExtension"]);
            $engagement->setBenefits($faker->text);
            $engagement->setProofText($faker->text);
            $engagement->setProofDocuments(["proofdocument$i.$faker->fileExtension",
                "proofdocument$i.$faker->fileExtension"]);
            $rand = rand(0, 1);
            $engagement->setIsConform($faker->boolean());
            if ($rand===0) {
                for ($o=1; $o<=3; $o++) {
                    $engagement->addOdd($this->getReference('odd_'.rand(1, 17)));
                }
            } else {
                $engagement->addRse($this->getReference('rse_type'.rand(0, 20)));
            }
            $this->addReference('engagement_'.$i, $engagement);
            $manager->persist($engagement);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class,RseCriteriaFixtures::class];
    }
}
