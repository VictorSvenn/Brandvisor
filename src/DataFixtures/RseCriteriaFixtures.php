<?php

namespace App\DataFixtures;

use App\Entity\RseCriteria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RseCriteriaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            0 => [
                "Engagement de la direction et projet stratégique",
                "Mise en œuvre opérationnelle de la responsabilité sociétale",
                "Mise en œuvre opérationnelle de la responsabilité sociétale",
                "Organisation de la veille réglementaire et normative",
                "Communication interne et externe",
            ],
            1 => [
                'Respect des droits de l\'homme',
                'Emploi et Relation Employeurs / Salariés',
                'Condition de travail et protection sociale',
                'Dialogue social',
                'Santé et sécurité au travail',
                'Développement du capital humain et lutte contre les discriminations',
            ],
            2 => [
                'Prévention de la pollution',
                'Utilisation durable des ressources',
                'Atténuation du Changement climatique',
                'Biodiversité',
            ],
            3 => [
                'Lutte contre la coruption',
                'Relations avec les pouvoirs publics',
                'Concurrence loyale et respect des droits de propriété',
                'Achat responsable et promotion de la responsabilité sociétale de la chaîne de valeur',
            ],
            4 => [
                'Protection des consommateurs',
                'Accompagner les consommateurs vers une consommation responsable',
                'Satisfaction des clients et consommateurs'
            ],
            5 => [
                'Satisfaction des clients et consommateurs',
                'Créatrion d\'emploi et développement des compétences'
            ]
        ];
        $tmp = 0;
        $otmp = 0;
        foreach ($data as $category => $type) {
            foreach ($type as $index => $value) {
                $type = new RseCriteria();
                $type->setName($value);
                $type->setCategory($this->getReference('rse_' . $tmp));
                $this->addReference('rse_type' . $otmp, $type);
                $manager->persist($type);
                $manager->flush();
                $otmp++;
                $azert = $category;
                $azert = $index;
            }
            $tmp++;
        }
    }

    public function getDependencies()
    {
        return [RseCategoryFixtures::class];
    }
}
