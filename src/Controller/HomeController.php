<?php

namespace App\Controller;

use App\Repository\ChallengeRepository;
use App\Repository\EnterpriseRepository;
use App\Repository\InitiativeRepository;
use App\Repository\NewsRepository;
use App\Repository\OddRepository;
use App\Repository\OpinionRepository;
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
        OddRepository $oddRepo,
        ChallengeRepository $challRepo,
        NewsRepository $newsRepo,
        OpinionRepository $opinionRepo
    ): Response {
        // Fonction de recheche dans l'index
        $enterpriseResult = null;
        $initiativeResult = null;
        $oddResult = null;
        $form = false;
        if (isset($_POST['searchText']) && trim($_POST['searchText']) !="") {
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
        // Affichage des entreprises dans la page d'accueil
        $enterpriseNotes = $entRepo->findWhereNoteHigh();
        dump($enterpriseNotes);

        // Affichage des initiatives dans la page d'accueil
        $initiativeLikes = $initRepo->findWhereLikesHigh();

        // affichage d'un challenge random sur la page d'accueil
        $dayChallenge = $challRepo->findWhereVotes();
        $votes = count($dayChallenge->getLikes());

        //Affichage d'une thématique random sur l'accueil
        $thematique = $oddRepo->findAllOdd();

        // Affichage des dernières news dans le fil d'actualité
        $news = $newsRepo->findByDate();

        // Je choppe tous les avis consommateurs et je récupère seulement les deux derniers
        $consummerAdvices = $opinionRepo->findConsummerValidOpinions();
        // Je choppe tous les avis experts et je récupère seulement les deux derniers
        $expertAdvices = $opinionRepo->findExpertValidOpinions();

        return $this->render('/home/home.html.twig', [
            'enterprises' => $enterpriseResult,
            'initiatives' => $initiativeResult,
            'odds' => $oddResult,
            'form' => $form,
            'numResults' => $numResults,
            'enterpriseNotes' => $enterpriseNotes,
            'initiativeLikes' => $initiativeLikes,
            'dayChallenge' => $dayChallenge,
            'votes' => $votes,
            'thematique' => $thematique,
            'news' => $news,
            'consumerAdvices' => $consummerAdvices,
            'expertAdvices' => $expertAdvices,
        ]);
    }
}
