<?php

namespace App\DataFixtures;

use App\Entity\EnterpriseType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtptypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        include '../../data.php';
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
