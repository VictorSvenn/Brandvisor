<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++) {
            $contact = new Contact();
            $contact->setFirstName($faker->firstName);
            $contact->setLastName($faker->lastName);
            $contact->setMessage($faker->text);
            $contact->setReason($faker->word);
            $contact->setEmail($faker->email);
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
