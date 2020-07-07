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
    public function index(ExpertRepository $expertRepo): Response
    {
        $rse = null;
        $odds = null;
        $experts = [];
        $sent = 0;
        if (isset($_POST['searchText']) && trim($_POST['searchText']) != "") {
            $query = $_POST['searchText'];
            // Recherche des experts par nom
            $fNameExperts = $expertRepo->findWhereFirstNameLike($query);
            if (!empty($fNameExperts)) {
                $sent += 1;
            }
            $lNameExperts = $expertRepo->findWhereNameLike($query);
            if (!empty($lNameExperts)) {
                $sent +=2;
            }
            array_push($experts, $fNameExperts);
            array_push($experts, $lNameExperts);
            dump($experts);
        } else {
            $allExperts = $expertRepo->findAll();
            array_push($experts, $allExperts);
            dump($experts);
        }

        return $this->render('expertOpinions/index.html.twig', [
            'types' => $rse,
            'odds' => $odds,
            'experts' => $experts,
            'sent' => $sent
        ]);
    }

    /**
     * @Route("/categories", name="expert_categories")
     */
    public function categories(
        OddRepository $oddRepo,
        RseCategoryRepository $categoryRepo
    ): Response {

        $rse = $categoryRepo->findAll();
        $odds = $oddRepo->findAll();

        return $this->render('expertOpinions/categories.html.twig', [
            'odds' => $odds,
            'rses' => $rse,
        ]);
    }
}
