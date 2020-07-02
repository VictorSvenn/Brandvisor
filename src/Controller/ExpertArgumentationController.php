<?php

namespace App\Controller;

use App\Entity\ExpertArgumentation;
use App\Form\ExpertArgumentationType;
use App\Repository\ExpertArgumentationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/expert/argumentation")
 */
class ExpertArgumentationController extends AbstractController
{
    /**
     * @Route("/", name="expert_argumentation_index", methods={"GET"})
     */
    public function index(ExpertArgumentationRepository $expertArgRepo): Response
    {
        return $this->render('expert_argumentation/index.html.twig', [
            'expert_argumentations' => $expertArgRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="expert_argumentation_new", methods={"GET","POST"})
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

        return $this->render('expert_argumentation/new.html.twig', [
            'expert_argumentation' => $expertArgumentation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expert_argumentation_show", methods={"GET"})
     */
    public function show(ExpertArgumentation $expertArgumentation): Response
    {
        return $this->render('expert_argumentation/show.html.twig', [
            'expert_argumentation' => $expertArgumentation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="expert_argumentation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExpertArgumentation $expertArgumentation): Response
    {
        $form = $this->createForm(ExpertArgumentationType::class, $expertArgumentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expert_argumentation_index');
        }

        return $this->render('expert_argumentation/edit.html.twig', [
            'expert_argumentation' => $expertArgumentation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expert_argumentation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ExpertArgumentation $expertArgumentation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expertArgumentation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expertArgumentation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expert_argumentation_index');
    }
}
