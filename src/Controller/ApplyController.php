<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Job;
use App\Form\ApplyType;
use App\Services\Email\ApplySendler;
use App\Services\Uploader\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    /**
     * @Route("/candidature/{slug}/{id}/nouveau", name="apply_new")
     * @IsGranted("ROLE_USER")
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UploaderHelper $uploaderHelper
     * @param ApplySendler $applySendler
     * @return Response
     */
    public function new(Job $job, Request $request, EntityManagerInterface $manager, UploaderHelper $uploaderHelper, ApplySendler $applySendler)
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

    /**
     * @Route("candidature/suppression-candidature/{id}", name="apply_delete")
     * @Security("is_granted('ROLE_USER') and user === apply.getJob().getAuthor()")
     * @param Apply $apply
     * @param EntityManagerInterface $manager
     * @param UploaderHelper $uploaderHelper
     * @return RedirectResponse
     */
    public function delete(Apply $apply, EntityManagerInterface $manager, UploaderHelper $uploaderHelper)
    {
        $fileCvResume = $apply->getCvResume();
        $fileCoverLetter = $apply->getCoverLetter();

        $manager->remove($apply);
        $manager->flush();

        if($fileCvResume && $fileCoverLetter)
        {
            $uploaderHelper->deleteUploadFile(new Filesystem(), '/cvResume/', $fileCvResume);
            $uploaderHelper->deleteUploadFile(new Filesystem(), '/coverLetter/', $fileCoverLetter);
        }

        $this->addFlash(
            'success',
            "La candidature a bien été supprimé."
        );

        return $this->redirectToRoute('account_profile');
    }
}
