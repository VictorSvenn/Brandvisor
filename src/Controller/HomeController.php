<?php

namespace App\Controller;

use App\Repository\EnterpriseRepository;
use App\Repository\InitiativeRepository;
use App\Repository\OddRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        EnterpriseRepository $entRepo,
        InitiativeRepository $initRepo,
        OddRepository $oddRepo
    ): Response {
        // Fonction de recheche dans l'index
        $enterpriseResult = null;
        $initiativeResult = null;
        $oddResult = null;
        $form = false;
        if (isset($_POST['indexSearch'])) {
            $query = $_POST['searchText'];

            // Requête pour la table entreprise
            $enterpriseResult = $entRepo->findWhereNameLike($query);

            // Requête pour la table initiative
            $initiativeResult = $initRepo->findWhereNameAndKewordsLike($query);

            // Requête pour la table ODD
            $oddResult = $oddRepo->findWhereNameLike($query);
            $form = true;
            $numResults = count($enterpriseResult) + count($initiativeResult) + count($oddResult);
        } else {
            $numResults = 0;
        }
        $enterpriseNotes = $entRepo->findWhereNoteHigh();
        $initiativeLikes = $initRepo->findWhereNoteHigh();

        return $this->render('/home/home.html.twig', [
            'enterprises' => $enterpriseResult,
            'initiatives' => $initiativeResult,
            'odds' => $oddResult,
            'form' => $form,
            'numResults' => $numResults,
            'enterpriseNotes' => $enterpriseNotes,
            'initiativeLikes' => $initiativeLikes,
        ]);
    }
}
