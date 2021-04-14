<?php

namespace App\Controller;


use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{    
    /**
     * @Route("/", name="index")
     */
    public function index(UserPasswordEncoderInterface $passwordEncoder,Request $request,AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error == null) $this->render('header.html.twig', ['last_username' => $lastUsername]);
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'last_username' => $lastUsername, 'error' => $error,
            'registrationForm' => $form->createView(),
        ]);
        // return $this->redirectToRoute('app_register');
    }

    // /**
    //  * @Route("/account", name="account")
    //  */
    // public function account(AuthenticationUtils $authenticationUtils){
    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();

    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();
    //     return $this->render('pages/account.html.twig', ['last_username' => $lastUsername, 'error' => $error,]);
    // }

    // /**
    //  * @Route("/checkout", name="checkout")
    //  */
    // public function checkout(AuthenticationUtils $authenticationUtils)
    // {
    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();

    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();
    //     return $this->render('pages/checkout.html.twig', ['last_username' => $lastUsername, 'error' => $error,]);
    // }
}
