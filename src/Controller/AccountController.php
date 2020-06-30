<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Form\EnterpriseType;
use App\Services\FileUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/enterprise", name="account_enterprise")
     */
    public function enterprise()
    {
        $enterprise = $this->getUser()->getEnterprise();
        return $this->render('account/enterprise.html.twig', [
            'enterprise' => $enterprise,
        ]);
    }

    /**
     * @Route("enterprise/opinions", name="enterprise_opinions")
     */
    public function etpOpinions(): Response
    {
        $user = $this->getUser();
        return $this->render('opinion/opinions.html.twig',['user'=>$user]);
    }

    /**
     * @Route("/{id}/edit", name="enterprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enterprise $enterprise, FileUpload $fileUpload): Response
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
            $files = $request->files->get('enterprise')['document_list'];
            foreach ($files as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
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
