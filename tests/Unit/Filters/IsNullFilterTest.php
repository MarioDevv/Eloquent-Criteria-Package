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
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\IsNullFilter;

class IsNullFilterTest extends TestCase
{
    public function test_is_null_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento de whereNull
        $builder->shouldReceive('whereNull')
            ->once()
            ->with('deleted_at')
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('deleted_at'),
            new FilterOperator(Operator::IS_NULL),
            new FilterValue(null)
        );

        $isNullFilter = new IsNullFilter();
        $result = $isNullFilter->apply($builder, $filter);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_is_null_filter_throws_error_on_non_null_value()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Filter(
            new FilterField('deleted_at'),
            new FilterOperator(Operator::IS_NULL),
            new FilterValue('not_null_value') // El valor debería ser nulo
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
