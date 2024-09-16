<?php
declare(strict_types=1);

namespace Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Criteria;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Operator;

class CriteriaBuilder
{

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Criteria $criteria
     * @return \Illuminate\Database\Eloquent\Builder
     * Función para aplicar un criterio a una consulta
     * Se recorren los filtros del criterio y se aplican a la consulta
     */
    public function apply(EloquentBuilder $query, Criteria $criteria): EloquentBuilder
    {
        foreach ($criteria->filters->value as $filter) {
            $query = $this->applyFilter($query, $filter);
        }

        $orderBy = $criteria->hasOrder() ? $criteria->order->orderBy->value : 'created_at';
        $orderType = $criteria->hasOrder() ? $criteria->order->orderType->value->value : 'desc';

        $query = $query->orderBy($orderBy, $orderType);

        return $query;
    }

    /**
     * @param EloquentBuilder $query
     * @param Filter $filter
     * @return EloquentBuilder
     * Función para aplicar un filtro a una consulta
     * Se verifica si el filtro tiene relaciones, si es así se aplica el filtro con relaciones
     */
    private function applyFilter(EloquentBuilder $query, Filter $filter): EloquentBuilder
    {

        if ($filter->hasRelations()) {
            return $this->applyFilterWithRelations($query, $filter);
        }

        if ($filter->operator->equals(Operator::BETWEEN)) {
            return $this->applyBetweenFilter($query, $filter);
        }

        if ($filter->operator->equals(Operator::IS_NULL)) {
            return $query->whereNull($filter->field->value);
        }

        if ($filter->operator->equals(Operator::IS_NOT_NULL)) {
            return $query->whereNotNull($filter->field->value);
        }

        if ($filter->operator->equals(Operator::WHERE_DATE)) {
            return $query->whereDate($filter->field->value, date_format(new \DateTime($filter->value->value), 'Y-m-d'));
        }

        return $query->where($filter->field->value, $filter->operator->value->value, $filter->value->value);
    }

    /**
     * @param EloquentBuilder $query
     * @param Filter $filter
     * @return EloquentBuilder
     * Función para aplicar un filtro con relaciones
     * El filtro debe tener un array de relaciones
     * Ejemplo: ['relation1', 'relation2']
     */
    private function applyFilterWithRelations(EloquentBuilder $query, Filter $filter): EloquentBuilder
    {
        $relationPath = implode('.', $filter->relations);
        $field = $filter->field->value;

        return $query->whereHas($relationPath, function ($query) use ($field, $filter) {
            $query->where($field, $filter->operator->value->value, $filter->value->value);
        });
    }

    /**
     * @param EloquentBuilder $builder
     * @param Filter $filter
     * @return EloquentBuilder
     * Función para aplicar el filtro de tipo BETWEEN
     * El value del filtro debe ser un array con dos valores
     */
    private function applyBetweenFilter(EloquentBuilder $builder, Filter $filter): EloquentBuilder
    {
        return $builder->whereBetween($filter->field->value, [$filter->value->value[0], $filter->value->value[1]]);

    }
}
