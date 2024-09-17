<?php
declare(strict_types=1);

namespace Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Criteria;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;

class CriteriaBuilder
{

    /**
     * @param EloquentBuilder $query
     * @param Criteria $criteria
     * @return EloquentBuilder
     * Función para aplicar un criterio a una consulta.
     * Se recorren los filtros del criterio y se aplican a la consulta.
     */
    public function apply(EloquentBuilder $query, Criteria $criteria): EloquentBuilder
    {
        foreach ($criteria->filters->value as $filter) {
            $query = $this->applyFilter($query, $filter);
        }

        $orderBy = $criteria->hasOrder() ? $criteria->order->orderBy->value : 'created_at';
        $orderType = $criteria->hasOrder() ? $criteria->order->orderType->value->value : 'desc';

        return $query->orderBy($orderBy, $orderType);
    }

    /**
     * @param EloquentBuilder $query
     * @param Filter $filter
     * @return EloquentBuilder
     * Se delega el manejo del filtro a la clase correspondiente.
     */
    private function applyFilter(EloquentBuilder $query, Filter $filter): EloquentBuilder
    {
        // Usamos la fábrica de filtros para obtener la clase adecuada
        $queryFilter = FilterFactory::create($filter->operator, $filter->relations);
        return $queryFilter->apply($query, $filter);
    }
}
