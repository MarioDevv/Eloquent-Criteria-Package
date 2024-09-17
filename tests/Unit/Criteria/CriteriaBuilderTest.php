<?php

namespace Tests\Unit\Criteria;

use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Criteria;
use Mariodevv\phpcriteriapackage\Infrastructure\Criteria\CriteriaBuilder;
use Mariodevv\phpcriteriapackage\Infrastructure\Criteria\EloquentQueryAdapter;

class CriteriaBuilderTest extends TestCase
{
    public function test_find_one_record()
    {
        $builder = Mockery::mock(Builder::class);

        $builder->shouldReceive('first')
            ->once()
            ->andReturn('single_record');

        $adapter = new EloquentQueryAdapter($builder);
        $criteriaBuilder = new CriteriaBuilder($adapter);

        $criteria = Criteria::none();

        $result = $criteriaBuilder->findOne($criteria);

        $this->assertEquals('single_record', $result);
    }

    public function test_find_many_records()
    {
        $builder = Mockery::mock(Builder::class);

        $builder->shouldReceive('get')
            ->once()
            ->andReturn('multiple_records');

        $adapter = new EloquentQueryAdapter($builder);
        $criteriaBuilder = new CriteriaBuilder($adapter);

        $criteria = Criteria::none();

        $result = $criteriaBuilder->findMany($criteria);

        $this->assertEquals('multiple_records', $result);
    }

    public function test_find_all_records()
    {
        $builder = Mockery::mock(Builder::class);

        $builder->shouldReceive('get')
            ->once()
            ->andReturn('all_records');

        $adapter = new EloquentQueryAdapter($builder);
        $criteriaBuilder = new CriteriaBuilder($adapter);

        $result = $criteriaBuilder->findAll();

        $this->assertEquals('all_records', $result);
    }

    public function test_paginate_records()
    {
        $builder = Mockery::mock(Builder::class);

        $builder->shouldReceive('paginate')
            ->once()
            ->with(10, ['*'], 'page', 1)
            ->andReturn('paginated_records');

        $adapter = new EloquentQueryAdapter($builder);
        $criteriaBuilder = new CriteriaBuilder($adapter);

        $criteria = Criteria::none();

        $result = $criteriaBuilder->paginate($criteria);

        $this->assertEquals('paginated_records', $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
