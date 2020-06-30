<?php

namespace App\DataFixtures;

use App\Entity\EnterpriseCategories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtpcategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $entreprisecategories = [
            'Aliments, boissons & tabac',
            'Animaux',
            'Argent & assurance',
            'Beauté & bien-être',
            'Construction & Manufacturing',
            'Loisirs & artisanat',
            'Maison & jardin',
            'Médias & édition',
            'Restaurants & bars',
            'Santé & médecine',
            'Services',
            'Services aux entreprises',
            'Services juridiques & administration',
            'Services publics & locaux',
            'Services à domicile',
            'Shopping & mode',
            'Sport',
            'Vacances & voyages',
            'Véhicules & transport',
            'Éducation & formation',
            'Électronique & technologie',
            'Événements & divertissement'];
        $tmp=0;
        foreach ($entreprisecategories as $entreprisecategory) {
            $category = new EnterpriseCategories();
            $category->setName($entreprisecategory);
            $this->addReference('etp_category'.$tmp, $category);
            $manager->persist($category);
            $manager->flush();
            $tmp++;
        }
    }
}
