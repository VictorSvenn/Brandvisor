<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Consumer;
use App\Entity\Enterprise;
use App\Entity\Expert;
use App\Entity\Initiative;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            //creating consumers
            $user = new User();
            $fname = $faker->firstName;
            $lname = $faker->lastName;
            $user->setFirstName($fname);
            $user->setLastName($lname);
            $user->setEmail("$fname.$lname@gmail.com");
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_CONSUMER']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $consumer = new Consumer();
            $consumer->setUser($user);
            $consumer->setGeographicArea($faker->city);
            $consumer->setBirthDate($faker->dateTime);

            $this->addReference('consumer_'.$i, $consumer);
            $manager->persist($consumer);
        }
        for ($i=11; $i<=20; $i++) {
            //creating experts
            $user = new User();
            $fname = $faker->firstName;
            $lname = $faker->lastName;
            $user->setFirstName($fname);
            $user->setLastName($lname);
            $user->setEmail("$fname.$lname@gmail.com");
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_EXPERT']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $expert = new Expert();
            $expert->setUser($user);
            $expert->setConnectingStructure($faker->company);
            $expert->setAdress($faker->address);
            $expert->setPhone($faker->phoneNumber);
            $expert->setPresentation($faker->text);
            $expert->setIllustration('expertIllustration.'.$faker->fileExtension);
            $expert->setWebsite($faker->url);
            $expert->setExpertiseAreas($faker->word);
            $expert->setInterventionZones($faker->city);
            $manager->persist($expert);

            $this->addReference('expert_'.$i, $expert);
        }
        for ($i=21; $i<=30; $i++) {
            //creating Enterprises
            $user = new User();
            $fname = $faker->firstName;
            $lname = $faker->lastName;
            $user->setFirstName($fname);
            $user->setLastName($lname);
            $user->setEmail("$fname.$lname@gmail.com");
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_ENTERPRISE']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $enterprise = new Enterprise();
            $enterprise->setUser($user);
            $enterprise->setName($faker->company);
            $enterprise->setNote($faker->randomNumber());
            $enterprise->setAdress($faker->address);
            $enterprise->setContactFunction($faker->jobTitle);
            $enterprise->setWebsite($faker->url);
            $enterprise->setSiret($faker->randomNumber());
            $enterprise->setLogo('enterpriseLogo.' . $faker->fileExtension);
            $enterprise->setEnterprisePhone($faker->phoneNumber);
            $enterprise->setEnterprisePres($faker->text);
            $enterprise->setDocuments(["etpdocument_$i.$faker->fileExtension", "etpdocument_$i.$faker->fileExtension"]);
            $enterprise->setType($this->getReference('etp_type'.rand(0, 500)));
            $this->addReference('etp_'.$i, $enterprise);
            $manager->persist($enterprise);
        }
        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('admin');
        $admin->setEmail('admin@brandvisor.fr');
        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [EtptypeFixtures::class];
    }
}
