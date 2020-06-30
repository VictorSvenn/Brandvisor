<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Form\EnterpriseType;
use App\Repository\EnterpriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enterprise")
 */
class EnterpriseController extends AbstractController
{
    /**
     * @Route("showChallenges", name="show_challenges")
     */
    public function showChallenges(): Response
    {
        $challenges = count($this->getUser()->getEnterprise()->getChallenges());
        return $this->render('challenges/etpchallenges.html.twig',['user' => $this->getUser(), 'nb' => $challenges]);
    }
}
