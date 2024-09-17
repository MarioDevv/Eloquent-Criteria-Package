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
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\EqualFilter;

class EqualFilterTest extends TestCase
{
    public function test_equal_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento del método where con EQUAL
        $builder->shouldReceive('where')
            ->once()
            ->with('id', '=', 1)
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('id'),
            new FilterOperator(Operator::EQUAL),
            new FilterValue(1)
        );

        $equalFilter = new EqualFilter();
        $result = $equalFilter->apply($builder, $filter);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_equal_filter_throws_error_on_invalid_value()
    {
        $this->expectException(\InvalidArgumentException::class);

        // Intentamos pasar un valor nulo
        new Filter(
            new FilterField('id'),
            new FilterOperator(Operator::EQUAL),
            new FilterValue(null)
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
