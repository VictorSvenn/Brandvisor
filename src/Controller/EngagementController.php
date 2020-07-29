<?php

namespace App\Controller;

use App\Entity\Engagement;
use App\Form\EngagementType;
use App\Repository\EngagementRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/engagement")
 */
class EngagementController extends AbstractController
{
    /**
     * @SuppressWarnings(PHPMD)
     * @Route("/new", name="engagement_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTERPRISE")
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $engagement = new Engagement();
        $form = $this->createForm(EngagementType::class, $engagement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $engagement->setOwner($this->getUser()->getEnterprise());
            $entityManager = $this->getDoctrine()->getManager();

            $docs = [];
            $actionDocs = $request->files->get('engagement')['actionDocuments'];
            foreach ($actionDocs as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
            }
            $engagement->setActionDocuments($docs);

            $docs = [];
            $resultDocs = $request->files->get('engagement')['resultsDocuments'];
            foreach ($resultDocs as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
            }
            $engagement->setResultsDocuments($docs);

            $docs = [];
            $proofDocs = $request->files->get('engagement')['proofDocuments'];
            foreach ($proofDocs as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
            }
            $engagement->setProofDocuments($docs);
            $enterprise = $this->getUser()->getEnterprise();
            
            $note = $enterprise->getNote();
            if (!empty($engagement->getActionText())) {
                $note += 1;
            }
            if (!empty($engagement->getResultsText())) {
                $note += 1;
            }
            $enterprise->setNote($note);
            
            $entityManager->persist($engagement);
            $entityManager->flush();

            return $this->redirectToRoute('account_enterprise');
        }

        return $this->render('engagement/new.html.twig', [
            'engagement' => $engagement,
            'form' => $form->createView(),
        ]);
    }
}
