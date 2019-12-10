<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\SearchJobType;
use App\Repository\JobRepository;
use App\Services\JobSearch\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/emplois", name="job_index")
     * @param JobRepository $repository
     * @param Request $request
     * @return Response
     */
    public function index(JobRepository $repository, Request $request)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchJobType::class, $data);
        $form->handleRequest($request);

        $jobs = $repository->findSearch($data);
        $findJobsNumber = count($jobs);

        return $this->render('job/jobs.html.twig', [
            'jobs' => $jobs,
            'form' => $form->createView(),
            'findJobNumber' => $findJobsNumber
        ]);
    }

    /**
     * @Route("/emplois/{slug}/{id}", name="job_show")
     * @param Job $job
     * @return Response
     */
    public function show(Job $job)
    {
        return $this->render('job/show.html.twig', [
            'job' => $job
        ]);
    }
}
