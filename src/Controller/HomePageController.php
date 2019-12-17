<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param JobRepository $repository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(JobRepository $repository, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        $lastJobs = $repository->lastJobs(5);

        return $this->render('homepage/homepage.html.twig', [
            'lastJobs' => $lastJobs,
            'countLastJobs' => count($lastJobs),
            'categories' => $categories,
        ]);
    }
}
