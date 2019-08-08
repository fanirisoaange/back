<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = [];
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/product')) {
                // ws_create_product
                if ('/api/product' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\ProductController::createProductAction',  '_route' => 'ws_create_product',);
                }

                // ws_get_all_products
                if ('/api/products' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\ProductController::getProductsAction',  '_route' => 'ws_get_all_products',);
                }

                // ws_update_product
                if (preg_match('#^/api/product/(?P<id>\\d+)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, ['_route' => 'ws_update_product']), array (  '_controller' => 'AppBundle\\Controller\\ProductController::updateProductAction',));
                }

            }

            // ws_get_product
            if (0 === strpos($pathinfo, '/api/getProduct') && preg_match('#^/api/getProduct/(?P<id>\\d+)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, ['_route' => 'ws_get_product']), array (  '_controller' => 'AppBundle\\Controller\\ProductController::getProductAction',));
            }

            // ws_delete_product
            if (0 === strpos($pathinfo, '/api/deleteProduct') && preg_match('#^/api/deleteProduct/(?P<id>\\d+)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, ['_route' => 'ws_delete_product']), array (  '_controller' => 'AppBundle\\Controller\\ProductController::deleteproductAction',));
            }

        }

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
