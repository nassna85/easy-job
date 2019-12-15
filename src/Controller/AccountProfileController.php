<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobNewType;
use App\Form\UserProfileEditType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $countJobs = count($jobByAuthor);

        return $this->render('account_profile/profile.html.twig', [
            'user' => $user,
            'jobs' => $jobByAuthor,
            'countJobs' => $countJobs
        ]);
    }

    /**
     * @Route("/profil/modification", name="account_profile_editUser")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editUser(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileEditType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre profil a bien été modifié"
            );
            return $this->redirectToRoute('account_profile');
        }

        return $this->render('account_profile/editUser.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/{slug}/{id}/editer", name="account_profile_editJob")
     * @Security("is_granted('ROLE_USER') and user === job.getAuthor()")
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editJob(Job $job, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(JobNewType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($job);
            $manager->flush();

            $this->addFlash(
                'success',
                "{$job->getAuthor()->getFirstName()}, votre emploi a bien été modifié."
            );
            return $this->redirectToRoute('account_profile');
        }

        return $this->render('account_profile/editJob.html.twig', [
            'job' => $job,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/{slug}/{id}/supprimer", name="account_profile_deleteJob")
     * @Security("is_granted('ROLE_USER') and user === job.getAuthor()")
     * @param Job $job
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleteJob(Job $job, EntityManagerInterface $manager)
    {
        $manager->remove($job);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'offre d'emploi a bien été supprimé."
        );

        return $this->redirectToRoute('account_profile');
    }
}