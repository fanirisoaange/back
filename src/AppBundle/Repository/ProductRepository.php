<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;


class ProductRepository extends  EntityRepository implements ProductRepositoryInterface
{


    public function getAllProduct()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');
        return $qb->getQuery()->getResult();
    }

    public function get(int $id) {
        return $this->find($id);
    }

    public function flush() {
        $this->getEntityManager()->flush();
    }

    public function remove(Product $object) {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    public function persist(Product $object) {
        $this->getEntityManager()->persist($object);
    }

    public function save(Product $object, $persist = false,$flush = true)
    {
        if ($persist) {
            $this->persist($object);
        }
        if ($flush) {
            $this->flush();
        }
        return $object;
    }




}