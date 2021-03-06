<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $user->setRoles(['ROLE_CONSUMER','ROLE_USER']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $consumer = new Consumer();
            $consumer->setUser($user);
            $consumer->setGeographicArea($faker->city);
            $consumer->setBirthDate($faker->dateTime);

            $this->addReference('consumer_' . $i, $consumer);
            $manager->persist($consumer);
        }
        for ($i = 11; $i <= 20; $i++) {
            //creating experts
            $user = new User();
            $fname = $faker->firstName;
            $lname = $faker->lastName;
            $user->setFirstName($fname);
            $user->setLastName($lname);
            $user->setEmail("$fname.$lname@gmail.com");
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $user->setRoles(['ROLE_EXPERT','ROLE_USER']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $expert = new Expert();
            $expert->setUser($user);
            $expert->setConnectingStructure($faker->company);
            $expert->setAdress($faker->address);
            $expert->setPhone($faker->phoneNumber);
            $expert->setPresentation($faker->text);
            $expert->setIllustration('11333805-1-ConvertImage.jpg');
            $expert->setWebsite($faker->url);
            $expert->setExpertiseAreas($faker->word);
            $expert->setInterventionZones($faker->city);
            $manager->persist($expert);

            $this->addReference('expert_' . $i, $expert);
        }
        for ($i = 21; $i <= 30; $i++) {
            //creating Enterprises
            $user = new User();
            $fname = $faker->firstName;
            $lname = $faker->lastName;
            $user->setFirstName($fname);
            $user->setLastName($lname);
            $user->setEmail("$fname.$lname@gmail.com");
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $user->setRoles(['ROLE_ENTERPRISE','ROLE_USER']);
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            $enterprise = new Enterprise();
            $enterprise->setUser($user);
            $enterprise->setName($faker->company);
            $enterprise->setNote($faker->numberBetween(0, 5));
            $enterprise->setAdress($faker->address);
            $enterprise->setContactFunction($faker->jobTitle);
            $enterprise->setWebsite($faker->url);
            $enterprise->setSiret($faker->randomNumber());
            $enterprise->setLogo('logo.jpg');
            $enterprise->setEnterprisePhone($faker->phoneNumber);
            $enterprise->setEnterprisePres($faker->text);
            $enterprise->setDocuments(["etpdocument_$i.$faker->fileExtension", "etpdocument_$i.$faker->fileExtension"]);
            $enterprise->setCategory($faker->jobTitle);
            $this->addReference('etp_' . $i, $enterprise);
            $manager->persist($enterprise);
        }
        $user = new User();
        $user->setEmail('admin@brandvisor.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $user->setFirstName('fname');
        $user->setLastName('lname');
        $manager->persist($user);
        $admin = new Admin();
        $admin->setUser($user);
        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [OddFixtures::class];
    }
}
