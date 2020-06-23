<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AccountController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }

    /**
     * @Route("/account/enterprise", name="account_enterprise")
     */
    public function enterprise()
    {
        $usert = $this->security->getUser()->getUsername();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $usert]);
        $enterprise = $this->getDoctrine()
            ->getRepository(Enterprise::class)
            ->findOneBy(['user' => $user]);
        return $this->render('account/enterprise.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
            'enterprise' => $enterprise,
        ]);
    }
}
