<?php

namespace Tests\Unit\Criteria;

use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Order;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\OrderBy;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Criteria;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Operator;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\OrderType;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\OrderTypes;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterField;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterValue;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterOperator;
use Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria\CriteriaBuilder;

class CriteriaBuilderTest extends TestCase
{
    public function test_apply_criteria_with_like_filter()
    {
        // Usamos Mockery para simular el Builder de Eloquent
        $builder = Mockery::mock(Builder::class);

        // Definimos el comportamiento esperado del filtro like
        $builder->shouldReceive('where')
            ->once()
            ->with('name', 'like', '%test%')
            ->andReturnSelf();

        // Simulación del método orderBy
        $builder->shouldReceive('orderBy')
            ->once()
            ->with('created_at', 'desc')
            ->andReturnSelf();

        // Creamos una instancia de CriteriaBuilder
        $criteriaBuilder = new CriteriaBuilder();

        // Creamos un filtro like
        $likeFilter = new Filter(
            new FilterField('name'),
            new FilterOperator(Operator::LIKE),
            new FilterValue('test')
        );

        // Creamos el OrderBy
        $orderBy = new Order(
            new OrderBy('created_at'),
            new OrderType(OrderTypes::DESC)
        );

        // Creamos los Filtros
        $filters = new Filters([$likeFilter]);

        // Creamos una instancia de Criteria
        $criteria = new Criteria($filters, $orderBy, 1, 10);

        // Aplicamos los criterios al builder
        $result = $criteriaBuilder->apply($builder, $criteria);

        // Verificamos que el método `apply` retorna el mismo builder
        $this->assertInstanceOf(Builder::class, $result);

        // Comprar propiedades del builder con los valores esperados
        $this->assertEquals($builder, $result);
    }

    public function test_apply_criteria_with_equal_filter()
    {
        // Usamos Mockery para simular el Builder de Eloquent
        $builder = Mockery::mock(Builder::class);

        // Definimos el comportamiento esperado del filtro igual
        $builder->shouldReceive('where')
            ->once()
            ->with('id', '=', 1)  // Comparamos con el valor del operador, no el objeto completo
            ->andReturnSelf();

        // Simulación del método orderBy
        $builder->shouldReceive('orderBy')
            ->once()
            ->with('created_at', 'desc')
            ->andReturnSelf();

        // Creamos una instancia de CriteriaBuilder
        $criteriaBuilder = new CriteriaBuilder();

        // Creamos un filtro igual (EQUAL)
        $equalFilter = new Filter(
            new FilterField('id'),
            new FilterOperator(Operator::EQUAL),
            new FilterValue(1)
        );

        // Creamos el OrderBy
        $orderBy = new Order(
            new OrderBy('created_at'),
            new OrderType(OrderTypes::DESC)
        );

        // Creamos los Filtros
        $filters = new Filters([$equalFilter]);

        // Creamos una instancia de Criteria
        $criteria = new Criteria($filters, $orderBy, 1, 10);

        // Aplicamos los criterios al builder
        $result = $criteriaBuilder->apply($builder, $criteria);

        // Verificamos que el método `apply` retorna el mismo builder
        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
