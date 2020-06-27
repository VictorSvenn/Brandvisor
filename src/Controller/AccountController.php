<?php

namespace App\Controller;

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
        $enterprise=$this->getUser()->getEnterprise();
        return $this->render('account/enterprise.html.twig', [
            'controller_name' => 'AccountController',
            'enterprise' => $enterprise,
        ]);
    }
}
