<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductController extends Controller
{

    public function renderToJson($data)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $response = new JsonResponse();
        $response->setContent($serializer->serialize($data, 'json'));
        $response->setContent($serializer->serialize($data, 'json'));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $response->headers->set('Content-Type', 'application/json', 'multipart/form-data', 'text/plain');
        $response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept, Authorization, Lang, token');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        return $response;
    }

    /**
     * Create a new product
     *
     * @Route("api/product", name="ws_create_product")
     * @Method({"POST"})
     */
    public function createProductAction(Request $request)
    {
        $data = json_decode($request->getContent());
        if (!is_object($data)) {
            $this->renderToJson( "Json ivalid");
        }
        $out = $this->get('manager.product')->createProduct($data);
        return $this->renderToJson($out);
    }

    /**
     * Get all products.
     *
     * @Route("/api/products", name="ws_get_all_products")
     * @Method({"GET"})
     */
    public function getProductsAction(Request $request)
    {
        $out = $this->get('manager.product')->getProducts();
        return $this->renderToJson($out);
    }

    /**
     * update a product.
     *
     * @Route("/api/product/{id}", name="ws_update_product", requirements={"id": "\d+"})
     * @Method({"PUT"})
     */
    public function updateProductAction(Request $request, $id)
    {
        $data = json_decode($request->getContent());
        $out = $this->get('manager.product')->updateProduct($id, $data);
        return $this->renderToJson($out);
    }

    /**
     * Get a product.
     *
     * @Route("/api/getProduct/{id}", name="ws_get_product", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function getProductAction($id)
    {
        $out = $this->get('manager.product')->getProduct($id);
        return $this->renderToJson($out);
    }



    /**
     * Delete product.
     *
     * @Route("/api/deleteProduct/{id}", name="ws_delete_product", requirements={"id": "\d+"})
     * @Method({"DELETE"})
     */
    public function deleteproductAction($id)
    {
        $out = $this->get('manager.product')->remove($id);
        return $this->renderToJson($out);
    }

}