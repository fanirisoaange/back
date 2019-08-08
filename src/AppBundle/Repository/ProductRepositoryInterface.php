<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Product;

interface ProductRepositoryInterface
{
    public function getAllProduct();
    public function get(int $id);
    public function flush();
    public function remove(Product $object);
    public function save(Product $object,$persist = false, $flush = true);

}