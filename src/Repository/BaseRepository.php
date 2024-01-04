<?php

namespace App\Repository;

use App\Entity\Catalog;
use App\Exception\ServiceHttpException;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of object
 * @template-extends ServiceEntityRepository<T>
 *
 * @method T|null find($id, $lockMode = null, $lockVersion = null)
 * @method T|null findOneBy(array $criteria, array $orderBy = null)
 * @method T[]    findAll()
 * @method T[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class BaseRepository extends ServiceEntityRepository
{

    /**
     * Summary of findOrFail
     * @param string $id
     * @return T
     * @throws ServiceHttpException if catalog not found
     */
    public function findOrFail(string $id)
    {
        $entity = $this->find($id);
        if ($entity == null) {
            throw ServiceHttpException::createNotFoundException($this->getClassName() . " not found");
        }
        return $entity;
    }

}
