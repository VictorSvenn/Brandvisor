<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Engagement;
use App\Entity\Enterprise;
use App\Form\ChallengeType;
use App\Repository\ChallengeRepository;
use App\Repository\EnterpriseRepository;
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
     * @Route("/", name="challenge_index", methods={"GET"})
     */
    public function index(ChallengeRepository $challengeRepository) :Response
    {
        return $this->render('challenge/index.html.twig', [
            'challenges' => $challengeRepository->findAll(),
        ]);
    }

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
     * @IsGranted({"ROLE_EXPERT","ROLE_CONSUMER"})
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challenge->setDepositary($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();

            $documents = $form->get('documents')->getData();
            $filename = $fileUpload->upload($documents);
            $challenge->setDocuments($filename);

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
     * @Route("/{id}", name="challenge_show", methods={"GET"})
     */
    public function show(Challenge $challenge): Response
    {
        $likes=count($challenge->getLikes());
        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
            'likes' => $likes
        ]);
    }

    /**
     * @Route("/delete", name="challenge_delete")
     */
    public function delete(): Response
    {
        return $this->render('challenge/_delete_form.html.twig');
    }

    /**
     * @Route("/vote/{id}",name="vote_challenge")
     * @IsGranted("ROLE_USER")
     * @param Challenge $challenge
     * @return Response
     */
    public function vote(Challenge $challenge) :Response
    {
        $challenge->addLike($this->getUser());
        $this->getDoctrine()->getManager()->persist($challenge);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('challenge_show', ['id' => $challenge->getId()]);
    }
}
