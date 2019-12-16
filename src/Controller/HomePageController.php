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

        return $this->render('homepage/homepage.html.twig', [
            'lastJobs' => $repository->lastJobs(5),
            'categories' => $categories,
        ]);
    }
}
