<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountProfileController extends AbstractController
{
    /**
     * @Route("/profil", name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param JobRepository $repository
     * @return Response
     */
    public function profile(JobRepository $repository)
    {
        $user = $this->getUser();
        $jobByAuthor = $repository->findBy(["author" => $user]);

        return $this->render('account_profile/profile.html.twig', [
            'user' => $user,
            'jobs' => $jobByAuthor,
            'countJobs' => count($jobByAuthor)
        ]);
    }
}
