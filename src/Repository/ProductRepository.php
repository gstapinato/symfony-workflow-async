<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ServiceHttpException;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * Summary of findOrFail
    //  * @param string $id
    //  * @return \App\Entity\Product
    //  */
    // public function findOrFail(string $id): Product
    // {
    //     //TODO: Move this to generic Repository
    //     $product = $this->find($id);
    //     if ($product == null) {
    //         throw ServiceHttpException::createNotFoundException("Product not found");
    //     }
    //     return $product;
    // }

}
