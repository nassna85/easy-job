<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\AdminJobNewType;
use App\Form\JobNewType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminJobController extends AbstractController
{
    /**
     * @Route("/administration/emplois/{page<\d+>?1}", name="admin_job_index")
     * @IsGranted("ROLE_ADMIN")
     * @param JobRepository $repository
     * @param $page
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(JobRepository $repository, $page, PaginatorInterface $paginator)
    {
        $jobs = $paginator->paginate(
            $repository->findAll(),
            $page,
            10
        );

        return $this->render('admin/job/index.html.twig', [
            'jobs' => $jobs
        ]);
    }

    /**
     * @Route("/administration/emploi/nouveau", name="admin_job_new")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function new(EntityManagerInterface $manager, Request $request)
    {
        $job = new Job();
        $form = $this->createForm(AdminJobNewType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($job);
            $manager->flush();

            $this->addFlash(
                'success',
                "Un nouvel emploi a bien été enregistré."
            );
            return $this->redirectToRoute('admin_job_index');
        }
        return $this->render('admin/job/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/emploi/{slug}/{id}/modification", name="admin_job_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Job $job, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(JobNewType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($job);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'emploi a bien été modifié."
            );

            return $this->redirectToRoute('admin_job_index');
        }
        return $this->render('admin/job/edit.html.twig', [
            'form' => $form->createView(),
            'job' => $job
        ]);
    }

    /**
     * @Route("/administration/emploi/{slug}/supprimer/{id}", name="admin_job_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Job $job
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Job $job, EntityManagerInterface $manager)
    {
        $manager->remove($job);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'emploi a bien été supprimé."
        );

        return $this->redirectToRoute('admin_job_index');
    }
}
