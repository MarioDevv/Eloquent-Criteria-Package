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
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\BetweenFilter;

class BetweenFilterTest extends TestCase
{
    public function test_between_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento del método whereBetween
        $builder->shouldReceive('whereBetween')
            ->once()
            ->with('age', [18, 30])
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('age'),
            new FilterOperator(Operator::BETWEEN),
            new FilterValue([18, 30])
        );

        $betweenFilter = new BetweenFilter();
        $result = $betweenFilter->apply($builder, $filter);

        // Verificamos que el resultado es el builder modificado correctamente
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_between_filter_throws_error_on_invalid_value()
    {
        // Aquí simulamos que whereBetween exista aunque no lo usemos
        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('whereBetween')->andReturnSelf();

        // Expectativa de que se lanzará una InvalidArgumentException
        $this->expectException(\InvalidArgumentException::class);

        // Intentamos pasar un valor incorrecto (no es un array de dos valores)
        $filter = new Filter(
            new FilterField('age'),
            new FilterOperator(Operator::BETWEEN),
            new FilterValue(18) // Aquí debería ser un array [18, 30]
        );

        $betweenFilter = new BetweenFilter();
        $betweenFilter->apply($builder, $filter);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
