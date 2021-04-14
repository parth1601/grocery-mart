<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }
        
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
            if($error == null) $this->render('header.html.twig', ['last_username' => $lastUsername]);
            return $this->render('default/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
            
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {   
         
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function admin_login(AuthenticationUtils $authenticationUtils): Response
    {
            if ($this->getUser()) {
                return $this->redirectToRoute('admin');
            }
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
            return $this->render('@EasyAdmin/page/login.html.twig', 
                                    [   
                                        'last_username' => $lastUsername, 
                                        'error' => $error, 
                                        'csrf_token_intention' => 'authenticate',
                                        'target_path' => $this->generateUrl('admin'),
                                        'username_label' => 'Email',
                                        'password_label' => 'Password',
                                        'sign_in_label' => 'Log in',
                                        'username_parameter' => 'email',
                                        'password_parameter' => 'password',
                                        'translation_domain' => 'admin',
                                        'page_title' => 'Admin | login',
                                    ]
                                );
    }

    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function admin_logout()
    {
        
    }
}
