<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Enterprise;
use App\Entity\Opinion;
use App\Entity\Consumer;
use App\Entity\Recommandation;
use App\Form\EnterpriseType;
use App\Repository\EnterpriseRepository;
use App\Repository\ConsumerRepository;
use App\Repository\OpinionRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/enterprise")
 */
class EnterpriseController extends AbstractController
{
    /**
     * @Route("/challenges", name="show_challenges")
     * @IsGranted("ROLE_ENTERPRISE")
     */
    public function showChallenges(): Response
    {
        $challenges = count($this->getUser()->getEnterprise()->getChallenges());
        return $this->render('challenges/etpchallenges.html.twig', ['user' => $this->getUser(), 'nb' => $challenges]);
    }

    /**
     * @Route("/challenge/response/{id}", name="challenge_response")
     * @IsGranted("ROLE_ENTERPRISE")
     */
    public function responseChallenge(Challenge $challenge)
    {
        if (isset($_POST['submit']) and isset($_POST['text'])) {
            $challenge->setResponse($_POST['text']);
            $enterprise = $this->getUser()->getEnterprise();
            $this->getDoctrine()->getManager()->persist($challenge);
            $this->getDoctrine()->getManager()->persist($enterprise);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_challenges');
        }
        return $this->render('challenge/response.html.twig', ['challenge' => $challenge]);
    }

    /**
     * @Route("/account", name="account_enterprise")
     * @IsGranted("ROLE_ENTERPRISE")
     */
    public function enterprise()
    {
        $enterprise = $this->getUser()->getEnterprise();
        $recommandation = $this->getDoctrine()->getRepository(Recommandation::class)->findOneBy([
            "enterprise"=>$enterprise]);
        if (count($enterprise->getEngagements()) >= 5 && $enterprise->getNote() == 4) {
            $enterprise->setNote(5);
        }

        return $this->render('account/enterprise.html.twig', [
            'enterprise' => $enterprise,
            'recommandation' =>$recommandation,
        ]);
    }

    /**
     * @Route("/opinions", name="enterprise_opinions")
     * @IsGranted("ROLE_ENTERPRISE")
     */
    public function etpOpinions(OpinionRepository $opinionRepository): Response
    {
        $user = $this->getUser();
        $opinions = $opinionRepository->findAllValidOpinionsDesc($this->getUser()->getEnterprise());
        return $this->render('opinion/opinions.html.twig', ['user' => $user, 'opinions' => $opinions]);
    }

    /**
     * @Route("/{id}/edit", name="enterprise_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTERPRISE")
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
            if (!empty($request->files->get('enterprise')['document_list'])) {
                $files = $request->files->get('enterprise')['document_list'];
                foreach ($files as $file) {
                    $filename = $fileUpload->upload($file);
                    array_push($docs, $filename);
                }
                $enterprise->setDocuments($docs);
            }
            $this->getDoctrine()->getManager()->persist($enterprise);
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('account_enterprise');
        }

        return $this->render('enterprise/edit.html.twig', [
            'enterprise' => $enterprise,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/{id}", name="show_enterprise")
    */
    public function showEnterprise(Enterprise $enterprise, OpinionRepository $oprepo): Response
    {
        if (6 >= 5 && $enterprise->getNote() == 4) {
            $enterprise->setNote(5);
        }
        $recommandation = $this->getDoctrine()->getRepository(Recommandation::class)->findOneBy([
            "enterprise"=>$enterprise]);

        $this->getDoctrine()->getManager()->persist($enterprise);
        $this->getDoctrine()->getManager()->flush();

        return $this->render(
            'enterprise/consultation.html.twig',
            [
            'enterprise' => $enterprise,
            "experts" => $oprepo->findEnterpriseExpertValidOpinions($enterprise->getId()),
            "consummers" => $oprepo->findEnterpriseConsummerValidOpinions($enterprise->getId()),
            'recommandation' => $recommandation,
            ]
        );
    }
}
