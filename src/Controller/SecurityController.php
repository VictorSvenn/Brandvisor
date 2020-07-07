<?php

namespace App\Controller;

use App\Entity\Initiative;
use App\Entity\Odd;
use App\Entity\User;
use App\Repository\EnterpriseRepository;
use App\Repository\InitiativeRepository;
use App\Repository\OddRepository;
use LogicException;
use App\Entity\Enterprise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connected", name="app_connected")
     */
    public function connected(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('connected.html.twig');
    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }
}
