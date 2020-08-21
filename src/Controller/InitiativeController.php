<?php

namespace App\Controller;

use App\Entity\Initiative;
use App\Form\InitiativeType;
use App\Repository\InitiativeRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/initiative")
 */
class InitiativeController extends AbstractController
{
    /**
     * @Route("/new", name="initiative_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $initiative = new Initiative();
        $form = $this->createForm(InitiativeType::class, $initiative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $initiative->setDepositary($this->getUser());
            $initiative->setIsConform(false);
            $illustration = $form->get('illustration')->getData();
            $filename = $fileUpload->upload($illustration);
            $initiative->setIllustration($filename);

            $entityManager->persist($initiative);
            $entityManager->flush();


            if ($this->getUser()->getExpert()) {
                return $this->redirectToRoute('account_expert');
            } elseif ($this->getUser()->getEnterprise()) {
                return $this->redirectToRoute('account_enterprise');
            } else {
                return $this->redirectToRoute('account_consumer');
            }
        }

        return $this->render('initiative/new.html.twig', [
            'initiative' => $initiative,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="initiative_show", methods={"GET"})
     */
    public function show(Initiative $initiative): Response
    {
        $likes = $initiative->getLikes();
        return $this->render('initiative/show.html.twig', [
            'initiative' => $initiative,
            'likes' => count($likes),
        ]);
    }

    /**
     * @Route("/vote/{id}", name="initiative_vote")
     * @IsGranted("ROLE_USER")
     * @param Initiative $initiative
     * @return Response
     */
    public function vote(Initiative $initiative): Response
    {
        $initiative->addLike($this->getUser());
        $this->getDoctrine()->getManager()->persist($initiative);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('initiative_show', ['id' => $initiative->getId()]);
    }

//    /**
//     * @Route("/vote/{id}",name="vote_challenge")
//     */
//    public function vote(Challenge $challenge)
//    {
//        $challenge->addLike($this->getUser());
//        $this->getDoctrine()->getManager()->persist($challenge);
//        $this->getDoctrine()->getManager()->flush();
//
//        return $this->redirectToRoute('app_home');
//    }
}
