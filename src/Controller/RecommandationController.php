<?php

namespace App\Controller;

use App\Entity\Recommandation;
use App\Form\RecommandationType;
use App\Repository\RecommandationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\FileUpload;

/**
 * @Route("/recommandation")
 */
class RecommandationController extends AbstractController
{
    /**
     * @Route("/", name="recommandation_index", methods={"GET"})
     */
    public function index(RecommandationRepository $recommandationRepo): Response
    {
        $recommandationResult = null;
        $form = false;
        if (isset($_GET['searchText']) && trim($_GET['searchText']) !="") {
            $query = $_GET['searchText'];

            $recommandationResult = $recommandationRepo->findWhereName($query);

            $form = true;
            $numResults = count($recommandationResult);
        } else {
            $numResults = 0;
        }

        return $this->render('recommandation/index.html.twig', [
            'recommandations' => $recommandationResult,
            'all' => $recommandationRepo->findAll(),
            'form' => $form,
            'numResults' => $numResults,
        ]);
    }

    /**
     * @Route("/new", name="recommandation_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $recommandation = new Recommandation();
        $form = $this->createForm(RecommandationType::class, $recommandation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $recommandation->setEnterprise($this->getUser()->getEnterprise());
            $firstImage = $form->get('firstImage')->getData();
            $filename = $fileUpload->upload($firstImage);
            $recommandation->setFirstImage($filename);
        
            if (!empty($recommandation->getFirstImage())) {
                $secondImage = $form->get('secondImage')->getData();
                $filename = $fileUpload->upload($secondImage);
                $recommandation->setSecondImage($filename);
            }
            if (!empty($recommandation->getSecondImage())) {
                $thirdImage = $form->get('thirdImage')->getData();
                $filename = $fileUpload->upload($thirdImage);
                $recommandation->setThirdImage($filename);
            }
            if (!empty($recommandation->getThirdImage())) {
                $fourthImage = $form->get('fourthImage')->getData();
                $filename = $fileUpload->upload($fourthImage);
                $recommandation->setFourthImage($filename);
            }
                
            $entityManager->persist($recommandation);
            $entityManager->flush();


            return $this->redirectToRoute('recommandation_index');
        }

        return $this->render('recommandation/new.html.twig', [
            'recommandation' => $recommandation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recommandation_show", methods={"GET"})
     */
    public function show(Recommandation $recommandation): Response
    {
        return $this->render('recommandation/show.html.twig', [
            'recommandation' => $recommandation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recommandation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recommandation $recommandation): Response
    {
        $form = $this->createForm(RecommandationType::class, $recommandation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recommandation_index');
        }

        return $this->render('recommandation/edit.html.twig', [
            'recommandation' => $recommandation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recommandation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Recommandation $recommandation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recommandation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recommandation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recommandation_index');
    }
}
