<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Consumer;
use App\Entity\Enterprise;
use App\Form\ConsumerType;
use App\Repository\ConsumerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consumer")
 * @IsGranted("ROLE_CONSUMER")
 */
class ConsumerController extends AbstractController
{
    /**
     * @Route("/account", name="account_consumer")
     */
    public function consumer()
    {
        $consumer = $this->getUser()->getConsumer();
        return $this->render('account/consumer.html.twig', [
            'consumer' => $consumer,
        ]);
    }


//    /**
//     * @Route("/", name="consumer_index", methods={"GET"})
//     */
//    public function index(ConsumerRepository $consumerRepository): Response
//    {
//        return $this->render('consumer/index.html.twig', [
//            'consumers' => $consumerRepository->findAll(),
//        ]);
//    }
//
//    /**
//     * @Route("/new", name="consumer_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $consumer = new Consumer();
//        $form = $this->createForm(ConsumerType::class, $consumer);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($consumer);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('consumer_index');
//        }
//
//        return $this->render('consumer/new.html.twig', [
//            'consumer' => $consumer,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="consumer_show", methods={"GET"})
//     */
//    public function show(Consumer $consumer): Response
//    {
//        return $this->render('consumer/show.html.twig', [
//            'consumer' => $consumer,
//        ]);
//    }

    /**
     * @Route("/{id}/edit", name="consumer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consumer $consumer): Response
    {
        $form = $this->createForm(ConsumerType::class, $consumer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_consumer');
        }

        return $this->render('consumer/edit.html.twig', [
            'consumer' => $consumer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bookmark/remove/{id}",name="remove_bookmark")
     */
    public function removeBookmark(Enterprise $enterprise)
    {
        $this->getUser()->getConsumer()->removeBookmark($enterprise);
        $this->getDoctrine()->getManager()->persist($enterprise);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('consumer_favs');
    }

    /**
     * @Route("/bookmarks", name="consumer_favs")
     */
    public function bookmarks()
    {

        return $this->render('consumer/consumer_favs.html.twig');
    }
//    /**
//     * @Route("/{id}", name="consumer_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Consumer $consumer): Response
//    {
//        if ($this->isCsrfTokenValid('delete' . $consumer->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($consumer);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('consumer_index');
//    }
}
