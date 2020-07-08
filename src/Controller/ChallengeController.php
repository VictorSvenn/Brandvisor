<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Engagement;
use App\Entity\Enterprise;
use App\Form\ChallengeType;
use App\Repository\ChallengeRepository;
use App\Services\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/challenge")
 */
class ChallengeController extends AbstractController
{

    /**
     * @Route("/api/{id}", name="show_json_enterprise")
     */
    public function getAPIEnterpriseEngagements(Enterprise $enterprise, SerializerInterface $serializer): Response
    {
        $ctx = [AbstractNormalizer::ATTRIBUTES => ['name', 'id']];
        $json = $serializer->serialize($enterprise->getEngagements(), 'json', $ctx);
        return new Response($json, 200, ["Content-type" => "application/json"]);
    }

    /**
     * @Route("/new", name="challenge_new", methods={"GET","POST"})
     * @IsGranted("ROLE_EXPERT")
     * @IsGranted("ROLE_CONSUMER")
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challenge->setDepositary($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();

            $docs = [];
            $actionDocs = $request->files->get('challenge')['documents'];
            foreach ($actionDocs as $file) {
                $filename = $fileUpload->upload($file);
                array_push($docs, $filename);
            }
            $challenge->setDocuments($docs);
//            $engagement = $form->get('challenge_engagement')->getData();
//            $challenge->setEngagement($engagement);
            $entityManager->persist($challenge);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vote/{id}",name="vote_challenge")
     * @IsGranted("ROLE_USER")
     */
    public function vote(Challenge $challenge)
    {
        $challenge->addLike($this->getUser());
        $this->getDoctrine()->getManager()->persist($challenge);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app_home');
    }
}
