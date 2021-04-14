<?php

namespace App\Controller;

use App\Form\CartType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\OrderRepository;
use App\Form\RegistrationFormType;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request, CartManager $cartManager, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $form = $this->createForm(RegistrationFormType::class);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $cart = $cartManager->getCurrentCart($user);
        $form = $this->createForm(CartType::class, $cart);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cart->setUserId($user);
            $cartManager->save($cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('cart/index.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'cart' => $cart,
            'registrationForm' => $form->createView(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/placed/orders", name="placedorders")
     */
    public function placedOrders(OrderRepository $orderRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        // $orders = $this->getUser()->getOrders();
        $userId = $this->getUser()->getId();
        $orders = $orderRepository->getPlacedOrdersByUserId($userId);
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('cart/placedOrders.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'cart' => $orders,
            'registrationForm' => $form->createView(),
        ]);
    }
}
