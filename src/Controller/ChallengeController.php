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
     * @Route("/", name="challenge_index", methods={"GET"})
     */
    public function index(ChallengeRepository $challengeRepository): Response
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
//            $engagementID = $form->get('challenge_engagement')->getData();
//            $engagement = $this->getDoctrine()
//                ->getRepository(Engagement::class)
//                ->find($engagementID);
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
     * @Route("/{id}", name="challenge_show", methods={"GET"})
     */
    public function show(Challenge $challenge): Response
    {
        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="challenge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Challenge $challenge): Response
    {
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('challenge_index');
        }

        return $this->render('challenge/edit.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Challenge $challenge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_index');
    }
}
