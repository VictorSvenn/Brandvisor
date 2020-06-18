<?php

namespace App\DataFixtures;

use App\Entity\EnterpriseType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EtptypeFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = $this->container->get('kernel')->getRootDir() . "/DataFixtures/data.json";

        // on récupère le contenu du fichier csv ( avec toutes les données des villes à l'intérieur )
        // et on le décode à l'aide de serializer (que l'on obtient grâce au container)
        $data = $serializer->decode(file_get_contents($filepath), 'json');

        $tmp = 0;
        $otmp = 0;
        foreach ($data as $category => $type) {
            foreach ($type as $index => $value) {
                $type = new EnterpriseType();
                $type->setName($value);
                $type->setCategory($this->getReference('etp_category' . $tmp));
                $this->addReference('etp_type' . $otmp, $type);
                $manager->persist($type);
                $manager->flush();
                $otmp++;
                $azert = $data;
                $azert = $category;
                $azert = $index;
            }
            $tmp++;
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [EtpcategoriesFixtures::class];
    }
}
