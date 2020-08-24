<?php

namespace App\Controller;

use App\Entity\Initiative;
use App\Entity\News;
use App\Entity\Opinion;
use App\Entity\Engagement;
use App\Entity\Enterprise;
use App\Entity\User;
use App\Form\NewsType;
use App\Repository\EngagementRepository;
use App\Repository\EnterpriseRepository;
use App\Repository\InitiativeRepository;
use App\Repository\OpinionRepository;
use App\Repository\UserRepository;
use App\Services\FileUpload;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("admin/index", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("admin/news/new", name="news_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function validateOpinions(OpinionRepository $opinionRepository): Response
    {
        $opinions = $opinionRepository->findAllNotValidOpinionsDesc();
        return $this->render('admin/validate_opinions.html.twig', ['opinions' => $opinions]);
    }

    /**
     * @Route("admin/validate/initiatives", name="init_validate")
     * @IsGranted("ROLE_ADMIN")
     */
    public function validateInitiativve(InitiativeRepository $initiativeRepository): Response
    {
        $init = $initiativeRepository->findAllNotValid();
        return $this->render('admin/validate_init.html.twig', ['inits' => $init]);
    }

    /**
     * @Route("admin/validate/opinion/{id}", name="validate_opinion")
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function validateInit(Initiative $initiative): Response
    {
        $initiative->setIsConform(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($initiative);
        $entityManager->flush();
        return $this->redirectToRoute('init_validate');
    }

    /**
     * @Route("admin/validate/engagement", name="engagements_validate")
     * @IsGranted("ROLE_ADMIN")
     */
    public function validateEngagement(EngagementRepository $engagementRepository): Response
    {
        $engage = $engagementRepository->findAllNotValid();
        return $this->render('admin/validate_engagements.html.twig', [
            'engagements' => $engage,
            ]);
    }

    /**
     * @Route("admin/validate/engagement/{id}", name="validate_engagement")
     * @IsGranted("ROLE_ADMIN")
     */
    public function validateEngag(Engagement $engagement): Response
    {
        $engagement->setIsConform(true);
        $enterprise=$engagement->getOwner();
        $note = $enterprise->getNote();
        if ($note === 0) {
            $note = 1;
        } elseif ($note ===1) {
            $note = 2;
        } elseif ($note === 2) {
            $note = 3;
        } elseif ($note === 3) {
            $note = 4;
        } elseif ($note === 4) {
            $note = 4;
        } elseif ($note === 5) {
            $note = 5;
        }
        $enterprise->setNote($note);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($engagement);
        $entityManager->flush();
        return $this->redirectToRoute('engagements_validate', [
            'engagement' => $engagement,
        ]);
    }

    /**
     * @Route("admin/refusvalidate/engagement/{id}", name="refus_engagement")
     * @IsGranted("ROLE_ADMIN")
     */
    public function refuseEngag(Engagement $engagement): Response
    {
        $engagement->setIsConform(true);
        $enterprise=$engagement->getOwner();
        $note = $enterprise->getNote();
        if ($note === 0) {
            $note = 0;
        } elseif ($note === 1) {
            $note = 1;
        } elseif ($note === 2) {
            $note = 2;
        } elseif ($note === 3) {
            $note = 3;
        } elseif ($note === 4) {
            $note = 3;
        } elseif ($note === 5) {
            $note = 5;
        }
        $enterprise->setNote($note);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($engagement);
        $entityManager->flush();
        return $this->redirectToRoute('engagements_validate', [
            'engagement' => $engagement,
        ]);
    }
}
