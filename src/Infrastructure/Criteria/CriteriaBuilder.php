<?php

namespace Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Criteria;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\QueryAdapter;

class CriteriaBuilder
{
    private QueryAdapter $adapter;

    public function __construct(QueryAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Pagina los resultados basados en los criterios.
     * @param Criteria $criteria
     * @return mixed
     */
    public function paginate(Criteria $criteria)
    {
        $query = $this->applyCriteria($criteria);
        return $query->paginate($criteria->pageSize, ['*'], 'page', $criteria->pageNumber);
    }

    /**
     * Encuentra un único registro basado en los criterios.
     * @param Criteria $criteria
     * @return mixed
     */
    public function findOne(Criteria $criteria)
    {
        $query = $this->applyCriteria($criteria);
        return $query->first();
    }

    /**
     * Encuentra múltiples registros basados en los criterios.
     * @param Criteria $criteria
     * @return mixed
     */
    public function findMany(Criteria $criteria)
    {
        $query = $this->applyCriteria($criteria);
        return $query->get();
    }

    /**
     * Encuentra todos los registros sin tener en cuenta los criterios.
     * @return mixed
     */
    public function findAll()
    {
        return $this->adapter->getQuery()->get();
    }

    /**
     * Aplica los criterios al adaptador y retorna el query modificado.
     * @param Criteria $criteria
     * @return mixed
     */
    private function applyCriteria(Criteria $criteria)
    {
        foreach ($criteria->filters->value as $filter) {
            $this->adapter->applyFilter($filter);
        }

        if ($criteria->hasOrder()) {
            $this->adapter->applyOrder($criteria->order);
        }

        return $this->adapter->getQuery();
    }
}
