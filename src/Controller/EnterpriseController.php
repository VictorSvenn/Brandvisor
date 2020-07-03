<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Form\EnterpriseType;
use App\Repository\EnterpriseRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enterprise")
 * @IsGranted("ROLE_ENTERPRISE")
 */
class EnterpriseController extends AbstractController
{
    /**
     * @Route("/challenges", name="show_challenges")
     */
    public function showChallenges(): Response
    {
        $challenges = count($this->getUser()->getEnterprise()->getChallenges());
        return $this->render('challenges/etpchallenges.html.twig', ['user' => $this->getUser(), 'nb' => $challenges]);
    }


    /**
     * @Route("/account", name="account_enterprise")
     */
    public function enterprise()
    {
        $enterprise = $this->getUser()->getEnterprise();
        return $this->render('account/enterprise.html.twig', [
            'enterprise' => $enterprise,
        ]);
    }

    /**
     * @Route("/opinions", name="enterprise_opinions")
     */
    public function etpOpinions(): Response
    {
        $user = $this->getUser();
        return $this->render('opinion/opinions.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="enterprise_edit", methods={"GET","POST"})
     */
    public function editEnterprise(Request $request, Enterprise $enterprise, FileUpload $fileUpload): Response
    {
        $form = $this->createForm(EnterpriseType::class, $enterprise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('logo')->getData()) {
                $logo = $form->get('logo')->getData();
                $filename = $fileUpload->upload($logo);
                $enterprise->setLogo($filename);
            }
            $docs = [];
            if ($request->files->get('enterprise')['document_list']) {
                $files = $request->files->get('enterprise')['document_list'];
                foreach ($files as $file) {
                    $filename = $fileUpload->upload($file);
                    array_push($docs, $filename);
                }
            }
            $enterprise->setDocuments($docs);


            $this->getDoctrine()->getManager()->persist($enterprise);
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('account_enterprise');
        }

        return $this->render('enterprise/edit.html.twig', [
            'enterprise' => $enterprise,
            'form' => $form->createView(),
        ]);
    }
}