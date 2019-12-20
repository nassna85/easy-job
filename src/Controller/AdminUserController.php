<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserEditType;
use App\Form\AdminUserNewType;
use App\Form\UserRegistrationType;
use App\Repository\TokenUserRegistrationRepository;
use App\Repository\UserRepository;
use App\Services\Uploader\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/administration/utilisateurs/{page<\d+>?1}", name="admin_user_index")
     * @IsGranted("ROLE_ADMIN")
     * @param UserRepository $repository
     * @param $page
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(UserRepository $repository, $page, PaginatorInterface $paginator)
    {
        $users = $paginator->paginate(
            $repository->findBy(['active' => true]),
            $page,
            10
        );

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/administration/utilisateurs/nouveau", name="admin_user_new")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(AdminUserNewType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "Un nouvel utilisateur a bien été créé."
            );
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/utilisateurs/{id}/modifier", name="admin_user_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminUserEditType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur a bien été modifié."
            );
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/administration/utilisateur/supprimer/{id}", name="admin_user_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param TokenUserRegistrationRepository $repository
     * @param UploaderHelper $uploaderHelper
     * @return RedirectResponse
     */
    public function delete(User $user, EntityManagerInterface $manager, TokenUserRegistrationRepository $repository, UploaderHelper $uploaderHelper)
    {
        $token = $repository->findOneBy(['user' => $user]);
        $appliesByUser = $user->getApplies();

        //If this user have files cvResume and letterCover -> delete there
        if($appliesByUser)
        {
            for($i = 0; $i < count($appliesByUser); $i++)
            {
                $fileCvResume = $appliesByUser[$i]->getCvResume();
                $fileCoverLetter = $appliesByUser[$i]->getCoverLetter();
                $uploaderHelper->deleteUploadFile(new Filesystem(), '/cvResume/', $fileCvResume);
                $uploaderHelper->deleteUploadFile(new Filesystem(), '/coverLetter/', $fileCoverLetter);
            }
        }
        $manager->remove($token);
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'utilisateur a bien été supprimé."
        );
        return $this->redirectToRoute('admin_user_index');
    }
}
