<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/emplois", name="job_index")
     * @param JobRepository $repository
     * @return Response
     */
    public function index(JobRepository $repository)
    {
        $jobs = $repository->findSearch();

        return $this->render('job/jobs.html.twig', [
            'jobs' => $jobs
        ]);
    }
}
