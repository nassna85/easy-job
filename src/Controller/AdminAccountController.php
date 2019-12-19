<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/administration/connexion", name="admin_account_login")
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $username = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();

        return $this->render('admin/account/login.html.twig', [
            'username' => $username,
            'error' => $error
        ]);
    }

    /**
     * @Route("/administration/deconnexion", name="admin_account_logout")
     */
    public function logout()
    {

    }
}
