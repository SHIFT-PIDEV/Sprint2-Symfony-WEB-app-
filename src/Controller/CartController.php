<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add", name="add-cart")
     */
    public function add(Request $request): Response
    {
        $Cart = new Cart();
        $form = $this->createForm(CartType::class,$Cart);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Cart);

            $entityManager->flush();

            return $this->redirectToRoute('list-cart');

        }

        return $this->render("cart/add.html.twig", [
            "form_title" => "Ajouter au panier",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/cart/list", name="list-cart")
     */
    public function list(Request $request,PaginatorInterface $paginator)
    {
        $Cart = $this->getDoctrine()->getRepository(Cart::class)->findAll();
        $pagination = $paginator->paginate(
            $Cart, $request->query->getInt('page', 1), 2);
        return $this->render('cart/list.html.twig', [
            "nom" =>$pagination ,"cart"=> $Cart] );
    }
    /**
     * @Route("/navbar", name="nav_bar")
     */
    public function navbar(Request $request)
    {
        $Cart = $this->getDoctrine()->getRepository(Cart::class)->findAll();

        return $this->render('Front_navbar_footer.html.twig', [
            "cart"=> $Cart] );
    }
    /**
     * @Route("/cart/delete/{id}", name="delete-cart")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Cart = $entityManager->getRepository(Cart::class)->find($id);
        $entityManager->remove($Cart);
        $entityManager->flush();
        return $this->redirectToRoute('list-cart');
    }
    /**
     * @Route("/panier/edit/{id}", name="edit_cart")
     */
    public function editQuestion(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Cart = $entityManager->getRepository(Cart::class)->find($id);
        $form = $this->createForm(CartType::class,$Cart);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list-cart');

        }

        return $this->render("cart/add.html.twig", [
            "form_title" => "Modifier un element",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/cart/search ", name="search-cart")
     */
    public function search(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Cart::class);
        $requestString=$request->get('searchValue');
        $cart = $repository->findCartByName($requestString);
        $jsonContent = $Normalizer->normalize($cart, 'json',['groups'=>'cart:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }
    /**
     * @Route("/cart/list/sort", name="sort")
     */
    public function sortASCService(Request $request, PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cart::class)->findBy(array(),array("prix"=>"ASC"));


        $pagination = $paginator->paginate(
            $cour,
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        return $this->render("cart/listASC.html.twig", [
            "cart" => $pagination,
        ]);

    }

}
