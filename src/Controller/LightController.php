<?php

namespace App\Controller;

use App\Entity\Light;
use App\Form\LightType;
use App\Repository\LightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\FileUpload;

/**
 * @Route("/light")
 */
class LightController extends AbstractController
{
    /**
     * @Route("/", name="light_index", methods={"GET", "POST"})
     */
    public function index(LightRepository $lightRepository): Response
    {
        $lightResult = null;
        $form = false;
        if (isset($_POST['searchText']) && trim($_POST['searchText']) !="") {
            $query = $_POST['searchText'];

            $lightResult = $lightRepository->findWhereName($query);

            $form = true;
            $numResults = count($lightResult);
        } else {
            $numResults = 0;
        }
    
        return $this->render('light/index.html.twig', [
            'lights' => $lightResult,
            'all' => $lightRepository->findAll(),
            'form' => $form,
            'numResults' => $numResults,
        ]);
    }

    /**
     * @Route("/new", name="light_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $light = new Light();
        $form = $this->createForm(LightType::class, $light);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $light->setExpert($this->getUser()->getExpert());
            /*$image = $form->get('image')->getData();
            $filename = $fileUpload->upload($image);
            $light->setImage($filename);*/

            $entityManager->persist($light);
            $entityManager->flush();

            return $this->redirectToRoute('light_index');
        }

        return $this->render('light/new.html.twig', [
            'light' => $light,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="light_show", methods={"GET"})
     */
    public function show(Light $light): Response
    {
        return $this->render('light/show.html.twig', [
            'light' => $light,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="light_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Light $light): Response
    {
        $form = $this->createForm(LightType::class, $light);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('light_index');
        }

        return $this->render('light/edit.html.twig', [
            'light' => $light,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="light_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Light $light): Response
    {
        if ($this->isCsrfTokenValid('delete'.$light->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($light);
            $entityManager->flush();
        }

        return $this->redirectToRoute('light_index');
    }
}
