<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/administration/categories", name="admin_category_index")
     * @IsGranted("ROLE_ADMIN")
     * @param CategoryRepository $repository
     * @return Response
     */
    public function index(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/administration/categorie/nouveau", name="admin_category_new")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function new(EntityManagerInterface $manager, Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "Une nouvelle catégorie a bien été enregistrée."
            );
            return $this->redirectToRoute('admin_category_index');
        }
        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/categorie/{slug}/{id}/modifier", name="admin_category_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Category $category
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Category $category, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "La catégorie a bien été modifiée."
            );
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }
}
