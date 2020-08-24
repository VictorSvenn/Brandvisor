<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    /**
     * @Route("/CGU", name="CGU")
     */
    public function cgu()
    {
        return $this->render('legal/cgu.html.twig');
    }

    /**
     * @Route("/mentionsLegales", name="mentions_legales")
     */
    public function mentionsLegales()
    {
        return $this->render('legal/mentionsLegales.html.twig');
    }
}
