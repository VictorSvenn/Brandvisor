<?php

namespace App\DataFixtures;

use App\Entity\Odd;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OddFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $odd = [
            'Objectif 1. Éradication de la pauvreté',
            'Objectif 2. Lutte contre la faim',
            'Objectif 3. Bonne santé et bien-être',
            'Objectif 4. Accès à une éducation de qualité',
            'Objectif 5. Égalité entre les sexes',
            'Objectif 6. Accès à l\'eau salubre et à l\'assainissement',
            'Objectif 7. Energies fiables, durables et modernes, à un coût abordable',
            'Objectif 8. Accès à des emplois décents',
            'Objectif 9. Bâtir une infrastructure résiliente, promouvoir une industrialisation durable qui profite à 
            tous et encourager l’innovation',
            'Objectif 10. Réduction des inégalités',
            'Objectif 11. Villes et communautés durables',
            'Objectif 12. Consommation et production responsables',
            'Objectif 13. Lutte contre les changements climatiques',
            'Objectif 14. Conserver et exploiter de manière durable les océans et les mers aux fins du développement 
            durable',
            'Objectif 15. Vie terrestre',
            'Objectif 16. Justice et paix',
            'Objectif 17. Partenariats pour la réalisation des objectifs',

        ];
        $tmp = 0;
        foreach ($odd as $value) {
            $tmp++;
            $a = new Odd();
            $a->setName($value);
            $this->addReference('odd_' . $tmp, $a);
            $manager->persist($a);
            $manager->flush();
        }
    }
}