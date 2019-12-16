<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Job;
use App\Form\ApplyType;
use App\Services\Email\ApplySendler;
use App\Services\Uploader\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @param UploaderHelper $uploaderHelper
     * @param ApplySendler $applySendler
     * @return Response
     */
    public function index(Job $job, Request $request, EntityManagerInterface $manager, UploaderHelper $uploaderHelper, ApplySendler $applySendler)
    {
        $user = $this->getUser();
        $apply = new Apply();
        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $uploadedFileCvResume */
            $uploadedFileCvResume = $form['cvResume']->getData();

            /** @var UploadedFile $uploadedFileCoverLetter */
            $uploadedFileCoverLetter = $form['coverLetter']->getData();

            if($uploadedFileCvResume)
            {
                $newFileCvResume = $uploaderHelper->uploadFile($uploadedFileCvResume, '/cvResume');
                $apply->setCvResume($newFileCvResume);
            }

            if($uploadedFileCoverLetter)
            {
                $newFileCoverLetter = $uploaderHelper->uploadFile($uploadedFileCoverLetter, '/coverLetter');
                $apply->setCoverLetter($newFileCoverLetter);
            }

            $apply->setUser($user)
                  ->setJob($job);
            $manager->persist($apply);
            $manager->flush();

            $applySendler->applySendForConfirmation($user, $job);
            $applySendler->applySendToEmployee($apply);

            $this->addFlash(
                'success',
                "{$apply->getUser()->getFirstName()}, votre candidature a été envoyé avec succès ! Vous allez recevoir un email de confirmation. Merci de votre confiance."
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
