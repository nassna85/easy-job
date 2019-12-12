<?php

namespace App\Controller;

use App\Entity\TokenUserRegistration;
use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Services\Email\TokenSendler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/connexion", name="account_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="account_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/inscription", name="account_registration")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenSendler $tokenSendler
     * @return Response
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, TokenSendler $tokenSendler)
    {
        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash)
                 ->setRoles(["ROLE_USER"]);

            $token = new TokenUserRegistration($user);

            //Cascade so if persist token automatically persist User
            $manager->persist($token);
            $manager->flush();

            $tokenSendler->sendToken($user, $token);

            $this->addFlash(
                'success',
                "Votre compte a bien été enregistré. Un email de confirmation vous a été envoyé. Une fois votre email confirmé, vous pourrez vous connecter ! Merci..."
            );
            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/user-registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirmation-inscription/{value}", name="account_token_validation")
     * @param TokenUserRegistration $token
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function validateToken(TokenUserRegistration $token, EntityManagerInterface $manager)
    {
        $user = $token->getUser();

        if($user->getActive())
        {
            return $this->redirectToRoute('account_login', [
                'tokenAlreadyValidate' => true
            ]);
        }

        if($token->isValid())
        {
            $user->setActive(true);
            $manager->flush();

            return $this->redirectToRoute('account_login', [
                'tokenValid' => true
            ]);
        }

        //If Token is not valid, remove token and user from database
        $manager->remove($token);
        $manager->flush();

        $this->addFlash(
            'warning',
            "Votre token a expiré. Veuillez vous réinscrire et rééssayer. Le token n'est valide que 6 heures après la date de votre inscription !"
        );

        return $this->redirectToRoute('account_registration');
    }
}
