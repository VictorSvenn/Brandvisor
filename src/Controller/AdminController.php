<?php

namespace App\Controller;

use App\Entity\Initiative;
use App\Entity\News;
use App\Entity\Opinion;
use App\Form\NewsType;
use App\Repository\InitiativeRepository;
use App\Repository\OpinionRepository;
use App\Services\FileUpload;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("admin/index", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("admin/news/new", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $illustration = $request->files->get('news')['illustration'];

            $filename = $fileUpload->upload($illustration);

            $news->setIllustration($filename);

            $date = new DateTime();
            dump($date);
            $news->setDate($date);
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/validate/opinions", name="validate_opinions")
     */
    public function validateOpinions(OpinionRepository $opinionRepository): Response
    {
        $opinions = $opinionRepository->findAllNotValidOpinionsDesc();
        return $this->render('admin/validate_opinions.html.twig', ['opinions' => $opinions]);
    }

    /**
     * @Route("admin/validate/initiatives", name="init_validate")
     */
    public function validateInitiativve(InitiativeRepository $initiativeRepository): Response
    {
        $init = $initiativeRepository->findAllNotValid();
        return $this->render('admin/validate_init.html.twig', ['inits' => $init]);
    }

    /**
     * @Route("admin/validate/opinion/{id}", name="validate_opinion")
     */
    public function validateOpinion(Opinion $opinion): Response
    {
        $opinion->setIsConform(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($opinion);
        $entityManager->flush();
        return $this->redirectToRoute('validate_opinions');
    }

    /**
     * @Route("admin/validate/initiative/{id}", name="validate_init")
     */
    public function validateInit(Initiative $initiative): Response
    {
        $initiative->setIsConform(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($initiative);
        $entityManager->flush();
        return $this->redirectToRoute('init_validate');
    }
}
