<?php

namespace App\Controller;

use App\Services\Statistiques\Statistique;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/administration", name="admin_dashboard")
     * @IsGranted("ROLE_ADMIN")
     * @param Statistique $statistique
     * @return Response
     */
    public function index(Statistique $statistique)
    {
        $countTotalUsers = $statistique->getCountTotalUsers();
        $countTotalJobs = $statistique->getCountTotalJobs();
        $countTotalCategories = $statistique->getCountTotalCategories();
        $countTotalContact = $statistique->getCountTotalContact();
        $countTotalApplies = $statistique->getCountTotalApplies();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('countTotalUsers', 'countTotalJobs', 'countTotalCategories', 'countTotalContact', 'countTotalApplies')
        ]);
    }
}
