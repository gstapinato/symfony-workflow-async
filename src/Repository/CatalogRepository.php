<?php

namespace App\Repository;

use App\Entity\Catalog;
use App\Exception\ServiceException;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Catalog>
 *
 * @method Catalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalog[]    findAll()
 * @method Catalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    /**
     * Summary of findOrFail
     * @param mixed $id
     * @return \App\Entity\Catalog
     */
    public function findOrFail($id): Catalog
    {
        //TODO: Move this to generic Repository
        $catalog = $this->find($id);
        if ($catalog == null) {
            throw ServiceException::createNotFoundException("Catalog not found");
        }
        return $catalog;
    }

}
