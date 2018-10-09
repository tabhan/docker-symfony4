<?php
namespace App\Controller;
use App\Entity\Product;
use App\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormExampleController extends Controller
{
    /**
     * @Route("/", name="form_example")
     */
    public function formExampleAction(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('all_products');
        }
        return $this->render('/form/product.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/products",name="all_products")
     */
    public function showProductsAction(Request $request){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('/plp/products.html.twig',
            array('products'=>$products)
        );
    }
    /**
     * @Route("/delete/{id}", name="deleteProduct")
     */
    public function deleteAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('all_products');
    }
    /**
     * @Route("/edit/{id}", name="form_edit_example")
     */
    public function editAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('all_products');
        }
        return $this->render('/form/product.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}