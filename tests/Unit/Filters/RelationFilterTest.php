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
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\RelationFilter;

class RelationFilterTest extends TestCase
{
    public function test_relation_filter_applies_correctly()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento de whereHas para relaciones
        $builder->shouldReceive('whereHas')
            ->once()
            ->with('posts.comments', Mockery::on(function ($callback) {
                $relatedQuery = Mockery::mock(Builder::class);
                $relatedQuery->shouldReceive('where')
                    ->once()
                    ->with('content', '=', 'Good comment');
                $callback($relatedQuery);
                return true;
            }))
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('content'),
            new FilterOperator(Operator::EQUAL),
            new FilterValue('Good comment'),
            ['posts', 'comments']
        );

        $relationFilter = new RelationFilter();
        $result = $relationFilter->apply($builder, $filter);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_relation_filter_applies_correctly_with_multiple_relations()
    {
        $builder = Mockery::mock(Builder::class);

        // Simulamos el comportamiento de whereHas para relaciones
        $builder->shouldReceive('whereHas')
            ->once()
            ->with('posts.comments.likes', Mockery::on(function ($callback) {
                $relatedQuery = Mockery::mock(Builder::class);
                $relatedQuery->shouldReceive('where')
                    ->once()
                    ->with('content', '=', 'Good comment');
                $callback($relatedQuery);
                return true;
            }))
            ->andReturnSelf();

        $filter = new Filter(
            new FilterField('content'),
            new FilterOperator(Operator::EQUAL),
            new FilterValue('Good comment'),
            ['posts', 'comments', 'likes']
        );

        $relationFilter = new RelationFilter();
        $result = $relationFilter->apply($builder, $filter);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close(); 
    }
}
