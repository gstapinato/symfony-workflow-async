<?php

namespace App\Repository;

use App\Entity\Catalog;
use App\Exception\ServiceHttpException;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Catalog>
 *
 * @method Catalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalog[]    findAll()
 * @method Catalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
//class CatalogRepository extends ServiceEntityRepository
class CatalogRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    // /**
    //  * Summary of findOrFail
    //  * @param string $id
    //  * @return \App\Entity\Catalog
    //  * @throws ServiceHttpException if catalog not found
    //  */
    // public function findOrFail(string $id): Catalog
    // {
    //     //TODO: Move this to generic Repository
    //     $catalog = $this->find($id);
    //     if ($catalog == null) {
    //         throw ServiceHttpException::createNotFoundException("Catalog not found");
    //     }
    //     return $catalog;
    // }

}
