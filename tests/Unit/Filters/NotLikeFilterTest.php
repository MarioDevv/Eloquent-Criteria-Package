<?php

namespace Tests\Unit\Filters;

use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterField;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterOperator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterValue;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Operator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\NotLikeFilter;

class NotLikeFilterTest extends TestCase
{
    public function test_not_like_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento del método where con NOT LIKE
        $builder->shouldReceive('where')
            ->once()
            ->with('description', 'not like', '%test%')
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('description'),
            new FilterOperator(Operator::NOT_LIKE),
            new FilterValue('test')
        );

        $notLikeFilter = new NotLikeFilter();
        $result = $notLikeFilter->apply($builder, $filter);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_not_like_filter_throws_error_on_invalid_value()
    {
        $this->expectException(\InvalidArgumentException::class);

        // Intentamos pasar un valor no válido
        new Filter(
            new FilterField('description'),
            new FilterOperator(Operator::NOT_LIKE),
            new FilterValue(123)
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
