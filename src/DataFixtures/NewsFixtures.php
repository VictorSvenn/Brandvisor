<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $news = new News();
            $news->setDate($faker->dateTime);
            $news->setIllustration('news.jpg');
            $news->setTitle($faker->word);
            $news->setText($faker->text);
            $manager->persist($news);
        }

        $manager->flush();
    }
}
