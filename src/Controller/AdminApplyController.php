<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Repository\ApplyRepository;
use App\Services\Uploader\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminApplyController extends AbstractController
{
    /**
     * @Route("/administration/candidatures/{page<\d+>?1}", name="admin_apply_index")
     * @IsGranted("ROLE_ADMIN")
     * @param ApplyRepository $repository
     * @param $page
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(ApplyRepository $repository, $page, PaginatorInterface $paginator)
    {
        $applies = $paginator->paginate(
            $repository->findAll(),
            $page,
            10
        );

        return $this->render('admin/apply/index.html.twig', [
            'applies' => $applies
        ]);
    }

    /**
     * @Route("/administration/candidatures/supprimer/{id}", name="admin_apply_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Apply $apply
     * @param EntityManagerInterface $manager
     * @param UploaderHelper $uploaderHelper
     * @return RedirectResponse
     */
    public function delete(Apply $apply, EntityManagerInterface $manager, UploaderHelper $uploaderHelper)
    {
        $fileCvResume = $apply->getCvResume();
        $fileCoverLetter = $apply->getCoverLetter();

        if($fileCvResume && $fileCoverLetter)
        {
            $uploaderHelper->deleteUploadFile(new Filesystem(), '/cvResume/', $fileCvResume);
            $uploaderHelper->deleteUploadFile(new Filesystem(), '/coverLetter/', $fileCoverLetter);
        }

        $manager->remove($apply);
        $manager->flush();

        $this->addFlash(
            'success',
            "La candidature a bien été supprimée."
        );
        return $this->redirectToRoute('admin_apply_index');
    }
}
