<?php

namespace App\Controller;

use App\Entity\Expert;
use App\Entity\ExpertArgumentation;
use App\Form\Expert1Type;
use App\Form\ExpertArgumentationType;
use App\Form\ExpertType;
use App\Repository\ExpertRepository;
use App\Services\FileUpload;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expert")
 * @IsGranted("ROLE_EXPERT")
 */
class ExpertController extends AbstractController
{
    /**
     * @Route("/account", name="account_expert")
     */
    public function expert()
    {
        $expert = $this->getUser()->getExpert();
        return $this->render('account/expert.html.twig', [
            'expert' => $expert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="expert_edit", methods={"GET","POST"})
     */
    public function editExpert(Request $request, Expert $expert, FileUpload $fileUpload): Response
    {
        $form = $this->createForm(ExpertType::class, $expert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('illustration')->getData()) {
                $illustration = $form->get('illustration')->getData();
                $filename = $fileUpload->upload($illustration);
                $expert->setIllustration($filename);
            }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('account_expert');
        }

        return $this->render('expert/edit.html.twig', [
            'expert' => $expert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/argumentation/new", name="expert_argumentation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $expertArgumentation = new ExpertArgumentation();
        $form = $this->createForm(ExpertArgumentationType::class, $expertArgumentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $expertArgumentation->setDepositary($this->getUser()->getExpert());
            $expertArgumentation->setDate(new DateTime());
            $entityManager->persist($expertArgumentation);
            $entityManager->flush();

            return $this->redirectToRoute('account_expert');
        }

        return $this->render('expertOpinions/new.html.twig', [
            'expertOpinions' => $expertArgumentation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/argumentation/{id}", name="expert_argumentation_show", methods={"GET"})
     */
    public function show(ExpertArgumentation $expertArgumentation): Response
    {
        return $this->render('expertOpinions/show.html.twig', [
            'expertOpinions' => $expertArgumentation,
        ]);
    }
}
