<?php

namespace Tests\Unit\Filters;

use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterField;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterOperator;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterValue;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Operator;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\LikeFilter;

class LikeFilterTest extends TestCase
{
    public function test_like_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento del método where con LIKE
        $builder->shouldReceive('where')
            ->once()
            ->with('name', 'like', '%John%')
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('name'),
            new FilterOperator(Operator::LIKE),
            new FilterValue('John')
        );

        $likeFilter = new LikeFilter();
        $result = $likeFilter->apply($builder, $filter);

        // Verificamos que el resultado es el builder modificado correctamente
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_like_filter_throws_error_on_null_value()
    {
        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('where')->andReturnSelf();

        // Expectativa de que se lanzará una InvalidArgumentException
        $this->expectException(\InvalidArgumentException::class);

        // Intentamos pasar un valor nulo (no se permite en LIKE)
        $filter = new Filter(
            new FilterField('name'),
            new FilterOperator(Operator::LIKE),
            new FilterValue(null) // No debería permitir nulos
        );

        $likeFilter = new LikeFilter();
        $likeFilter->apply($builder, $filter);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
