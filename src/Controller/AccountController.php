<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/enterprise", name="account_enterprise")
     */
    public function enterprise()
    {
        $enterprise=$this->getUser()->getEnterprise();
        return $this->render('account/enterprise.html.twig', [
            'enterprise' => $enterprise,
        ]);
    }
}
