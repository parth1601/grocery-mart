<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Category;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\RegistrationFormType;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{


    /**
     * @Route("/get-products", name="getproducts", methods={"POST"})
     * 
     * @return Response
     */
    public function getProducts(ProductsRepository $productsRepository)
    {
        $categoryId = $_POST["id"];
        $products = $productsRepository->getProducts($categoryId);

        $responseArray = array();
        foreach ($products as $product) {
            $responseArray[] = array(
                "id" => $product->getId(),
                "key" => $product->getProductKey(),
                "name" => $product->getProductName(),
                "pb" => $product->getPriceBefore(),
                "pa" => $product->getPriceAfter(),
                "img" => $product->getProductImage(),
                "category" => $product->getCategory(),
                "brand" => $product->getProductBrand(),
                "subCategory" => $product->getSubCategory(),
                "imgFile" => $product->getProductImageFile(),
                "status" => $product->getProductStatus(),
                "expDate" => $product->getExpiryDate(),
                "getCOO" => $product->getCountryOfOrigin()
            );
        }
        return new JsonResponse($responseArray);
    }

    /**
     * @Route("/getproductbyid", name="getproductbyid")
     * 
     * @return Response
     */
    public function getProductById(ProductsRepository $productsRepository)
    {
        $id=$_POST["id"];
        $products = $productsRepository->getProductById($id);

        $responseArray = array();
        foreach ($products as $product) {
            $responseArray[] = array(
                "id" => $product->getId(),
                "key" => $product->getProductKey(),
                "name" => $product->getProductName(),
                "pb" => $product->getPriceBefore(),
                "pa" => $product->getPriceAfter(),
                "img" => $product->getProductImage(),
                "category" => $product->getCategory()->getCategory(),
                "brand" => $product->getProductBrand(),
                "subCategory" => $product->getSubCategory()->getSubCategory(),
                "description" => $product->getProductDescription(),
                "status" => $product->getProductStatus(),
                "expDate" => $product->getExpiryDate(),
                "getCOO" => $product->getCountryOfOrigin()
            );
        }
        return new JsonResponse($responseArray);
    }

    /**
     * @Route("/detail/{id}", name="products.detail")
     * 
     * @return Response
     */
    public function detail(AuthenticationUtils $authenticationUtils,Products $product, Request $request, CartManager $cartManager): Response
    {
        $user = $this->getUser();
        

        $rform = $this->createForm(RegistrationFormType::class);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user) {
            $item = $form->getData();
            $item->setProduct($product);
            $cart = $cartManager->getCurrentCart($user);
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);
            // return new Response("test");
            return $this->redirectToRoute('products.detail', ['id' => $product->getId()]);
        }

        return $this->render('products/detail.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'product' => $product,
            'registrationForm' => $rform->createView(),
            'form' => $form->createView(),
        ]);
    }
    
}
// /**
//      * @Route("/", name="products_index", methods={"GET"})
//      */
//     public function index(ProductsRepository $productsRepository): Response
//     {
//         return $this->render('products/index.html.twig', [
//             'products' => $productsRepository->findAll(),
//         ]);
//     }

//     /**
//      * @Route("/new", name="products_new", methods={"GET","POST"})
//      */
//     public function new(Request $request): Response
//     {
//         $product = new Products();
//         $form = $this->createForm(ProductsType::class, $product);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $entityManager = $this->getDoctrine()->getManager();
//             $entityManager->persist($product);
//             $entityManager->flush();

//             return $this->redirectToRoute('products_index');
//         }

//         return $this->render('products/new.html.twig', [
//             'product' => $product,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}", name="products_show", methods={"GET"})
//      */
//     public function show(Products $product): Response
//     {
//         return $this->render('products/show.html.twig', [
//             'product' => $product,
//         ]);
//     }

//     /**
//      * @Route("/{id}/edit", name="products_edit", methods={"GET","POST"})
//      */
//     public function edit(Request $request, Products $product): Response
//     {
//         $form = $this->createForm(ProductsType::class, $product);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $this->getDoctrine()->getManager()->flush();

//             return $this->redirectToRoute('products_index');
//         }

//         return $this->render('products/edit.html.twig', [
//             'product' => $product,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}", name="products_delete", methods={"DELETE"})
//      */
//     public function delete(Request $request, Products $product): Response
//     {
//         if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
//             $entityManager = $this->getDoctrine()->getManager();
//             $entityManager->remove($product);
//             $entityManager->flush();
//         }

//         return $this->redirectToRoute('products_index');
//     }