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
     * @Route("/", name="expert_annuary")
     */
    public function index(ExpertRepository $expertRepo):Response
    {
        $rse = null;
        $odds = null;
        if (isset($_POST['searchText']) && trim($_POST['searchText']) !="") {
            $query = $_POST['searchText'];
            // Recherche des experts par nom
            $experts = $expertRepo->findWhereNameLike($query);
        } else {
            $experts = $expertRepo->findAll();
        }

        return $this->render('expertOpinions/index.html.twig', [
            'types' => $rse,
            'odds' => $odds,
            'experts' => $experts,
        ]);
    }

    /**
     * @Route("/categories", name="expert_categories")
     */
    public function categories(
        OddRepository $oddRepo,
        RseCategoryRepository $categoryRepo
    ):Response {

        $rse = $categoryRepo->findAll();
        $odds = $oddRepo->findAll();

        return $this->render('expertOpinions/categories.html.twig', [
            'odds' => $odds,
            'rses' => $rse,
        ]);
    }
}
