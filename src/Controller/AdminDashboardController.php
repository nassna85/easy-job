<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/administration", name="admin_dashboard")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
