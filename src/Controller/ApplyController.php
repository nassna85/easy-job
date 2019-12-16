<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Job;
use App\Form\ApplyType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    /**
     * @Route("/candidature/{slug}/{id}", name="apply_index")
     * @IsGranted("ROLE_USER")
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Job $job, Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $apply = new Apply();
        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $apply->setUser($user)
                  ->setJob($job);
            $manager->persist($apply);
            $manager->flush();

            $this->addFlash(
                'success',
                "{$apply->getUser()->getFirstName()}, votre candidature a été envoyé avec succès ! Merci de votre confiance."
            );
            return $this->redirectToRoute('account_profile');
        }

        return $this->render('apply/index.html.twig', [
            'job' => $job,
            'user' => $user,
            'form' => $form-> createView()
        ]);
    }
}
