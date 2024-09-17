<?php

namespace Tests\Unit\Filters;

use Mockery;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterField;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterOperator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterValue;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Operator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\WhereDateFilter;

class WhereDateFilterTest extends TestCase
{
    public function test_where_date_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        $expectedDate = '2024-09-16'; // La fecha esperada que pasará al método whereDate

        // Simulamos el comportamiento del método whereDate con la fecha formateada
        $builder->shouldReceive('whereDate')
            ->once()
            ->with('created_at', $expectedDate)
            ->andReturnSelf();

        // Creamos el filtro con la fecha sin formato específico
        $filter = new Filter(
            new FilterField('created_at'),
            new FilterOperator(Operator::WHERE_DATE),
            new FilterValue($expectedDate)
        );

        
        // Aplicamos el filtro
        $whereDateFilter = new WhereDateFilter();
        $result = $whereDateFilter->apply($builder, $filter);
        
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_where_date_filter_throws_error_on_invalid_date_format()
    {
        $this->expectException(\InvalidArgumentException::class);

        // Pasamos un valor de fecha no válido
        new Filter(
            new FilterField('created_at'),
            new FilterOperator(Operator::WHERE_DATE),
            new FilterValue('invalid_date')
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
