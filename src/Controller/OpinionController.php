<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Form\OpinionType;
use App\Repository\OpinionRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/opinion")
 */
class OpinionController extends AbstractController
{
    /**
     * @Route("/new", name="opinion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $opinion = new Opinion();
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $date = new DateTime();
            $opinion->setDate($date);
            $opinion->setDepositary($this->getUser());
            $opinion->setIsConform(false);
            $entityManager->persist($opinion);
            $entityManager->flush();
            if ($this->getUser()->getExpert()) {
                return $this->redirectToRoute('account_expert');
            } elseif ($this->getUser()->getEnterprise()) {
                return $this->redirectToRoute('account_enterprise');
            } else {
                return $this->redirectToRoute('account_consumer');
            }
        }

        return $this->render('opinion/new.html.twig', [
            'opinion' => $opinion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="opinion_show", methods={"GET"})
     */
    public function show(Opinion $opinion): Response
    {
        return $this->render('opinion/show.html.twig', [
            'opinion' => $opinion,
        ]);
    }
}
