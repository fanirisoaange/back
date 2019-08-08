<?php

namespace AppBundle\Manager;


interface ProductManagerInterface
{
    public function createProduct(Object $data);
    public function updateProduct(int $id,Object $data);
    public function getProduct(int $id);
    public function remove(int $id);
    public function getProducts();
}