<?php

namespace App\Controller;

use App\Entity\Recruitment;
use App\Form\RecruitmentType;
use App\Repository\RecruitmentRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recruitment")
 */
class RecruitmentController extends AbstractController
{
    /**
     * @Route("/", name="recruitment_index", methods={"GET"})
     */
    public function index(RecruitmentRepository $recruitRepository): Response
    {
        return $this->render('recruitment/index.html.twig', [
            'recruitments' => $recruitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recruitment_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $recruitment = new Recruitment();
        $form = $this->createForm(RecruitmentType::class, $recruitment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $docs = [];
            $actionDocs = $request->files->get('recruitment')['image'];
            foreach ($actionDocs as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
            }
            $recruitment->setImage($docs);

            $entityManager->persist($recruitment);
            $entityManager->flush();

            return $this->redirectToRoute('recruitment_index');
        }

        return $this->render('recruitment/new.html.twig', [
            'recruitment' => $recruitment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recruitment_show", methods={"GET"})
     */
    public function show(Recruitment $recruitment): Response
    {
        return $this->render('recruitment/show.html.twig', [
            'recruitment' => $recruitment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recruitment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recruitment $recruitment): Response
    {
        $form = $this->createForm(RecruitmentType::class, $recruitment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recruitment_index');
        }

        return $this->render('recruitment/edit.html.twig', [
            'recruitment' => $recruitment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recruitment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Recruitment $recruitment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recruitment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recruitment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recruitment_index');
    }
}
