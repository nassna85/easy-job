<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Job;
use App\Form\JobNewType;
use App\Form\SearchJobType;
use App\Repository\JobRepository;
use App\Services\Email\JobSendler;
use App\Services\JobSearch\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        //For knp paginator, get page
        $data->setPage((int) $request->get('page', 1));

        //Test si nombre entier en parametre de page ou autre chose
        if($data->getPage() === 0)
        {
            $data->setPage(1);
        }

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
     * @Route("/emplois/categorie/{slug}", name="job_category")
     * @param Category $category
     * @return Response
     */
    public function showCategory(Category $category)
    {
        $jobsByCategories = $category->getJobs();

        return $this->render('job/showCategory.html.twig', [
            'jobsByCategories' => $jobsByCategories,
            'currentCategory' => $category
        ]);
    }

    /**
     * @Route("/emplois/{slug}/{id}", name="job_show")
     * @param Job $job
     * @return Response
     */
    public function show(Job $job)
    {
        $user = $this->getUser();
        return $this->render('job/show.html.twig', [
            'job' => $job,
            'user' => $user
        ]);
    }

    /**
     * @Route("/emplois/nouveau", name="job_new")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param JobSendler $jobSendler
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager, JobSendler $jobSendler)
    {
        $user = $this->getUser();

        $job = new Job();
        $form = $this->createForm(JobNewType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $job->setAuthor($user);
            $manager->persist($job);
            $manager->flush();

            $jobSendler->confirmationNewJobCreatedForEmployee($job);
            $jobSendler->confirmationNewJobCreated($job);

            $this->addFlash(
                'success',
                "Votre nouvel emploi a bien été créé. Nous vous remerçions pour votre confiance !"
            );
            return $this->redirectToRoute('job_show', [
                'id' => $job->getId(),
                'slug' => $job->getSlug()
            ]);
        }

        return $this->render('job/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
