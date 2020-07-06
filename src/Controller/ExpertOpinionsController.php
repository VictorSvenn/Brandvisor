<?php

namespace App\Controller;

use App\Entity\RseCategory;
use App\Repository\ExpertArgumentationRepository;
use App\Repository\ExpertRepository;
use App\Repository\OddRepository;
use App\Repository\OpinionRepository;
use App\Repository\RseCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ExpertOpinions")
 */
class ExpertOpinionsController extends AbstractController
{
    /**
     * @Route("/", name="expert_opinions")
     */
    public function index(
        RseCategoryRepository $rseCategoryRepo,
        OddRepository $oddRepo,
        ExpertRepository $expertRepo
    ):Response {
        $rse = null;
        $odds = null;
        $expertResults = null;
        if (isset($_POST['indexSearch'])) {
            $query = $_POST['searchText'];
            // Recherche des experts par nom
            $expertResults = $expertRepo->findWhereNameLike($query);

            $rse = $rseCategoryRepo->findAll();
            $odds = $oddRepo->findAll();
            dump($expertResults);
        }
        return $this->render('expertOpinions/index.html.twig', [
            'types' => $rse,
            'odds' => $odds,
            'experts' => $expertResults,
        ]);
    }
}
