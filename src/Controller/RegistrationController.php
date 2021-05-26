<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('0704868fb2-7e0da3@inbox.mailtrap.io', 'Grocery Mart'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            // if($user->isVerified()){
            //     return $guardHandler->authenticateUserAndHandleSuccess(
            //         $user,
            //         $request,
            //         $authenticator,
            //         'main' // firewall name in security.yaml
            //     );
            // }
            // $error = $authenticationUtils->getLastAuthenticationError();

            // $lastUsername = $authenticationUtils->getLastUsername();
            // $this->render('default/index.html.twig', [
            //     'last_username' => $lastUsername,
            //     'error' => $error,
            //     'registrationForm' => $form->createView(),
            // ]);
            return $this->redirectToRoute('index');
            
        }

        // $error = $authenticationUtils->getLastAuthenticationError();

        // $lastUsername = $authenticationUtils->getLastUsername();
        // $this->render('default/index.html.twig', [
        //     'last_username' => $lastUsername,
        //     'error' => $error,
        //     'registrationForm' => $form->createView(),
        // ]);
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
       
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('index');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        // $this->addFlash('success', 'Your email address has been verified.');
        // $form = $this->createForm(RegistrationFormType::class);
        // $error = $authenticationUtils->getLastAuthenticationError();

        // $lastUsername = $authenticationUtils->getLastUsername();
        // $this->render('default/index.html.twig', [
        //     'last_username' => $lastUsername,
        //     'error' => $error,
        //     'registrationForm' => $form->createView(),
        // ]);
        return $this->redirectToRoute('index');
    }
}
