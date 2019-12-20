<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\AdminContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/administration/contact/{page<\d+>?1}", name="admin_contact_index")
     * @IsGranted("ROLE_ADMIN")
     * @param ContactRepository $repository
     * @param $page
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(ContactRepository $repository, $page, PaginatorInterface $paginator)
    {
        $contacts = $paginator->paginate(
            $repository->findAll(),
            $page,
            10
        );

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/administration/contact/{id}/modifier", name="admin_contact_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Contact $contact
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Contact $contact, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "La demande de contact a bien été résolue."
            );
            return $this->redirectToRoute('admin_contact_index');
        }
        return $this->render('admin/contact/edit.html.twig', [
            'form' => $form-> createView(),
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/administration/contact/supprimer/{id}", name="admin_contact_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Contact $contact
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Contact $contact, EntityManagerInterface $manager)
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash(
            'success',
            "La demande de contact a bien été supprimée."
        );
        return $this->redirectToRoute('admin_contact_index');
    }
}
