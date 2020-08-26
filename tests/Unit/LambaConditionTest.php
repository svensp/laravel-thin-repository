<?php

namespace ThinRepositoryTests\Unit;

use Mockery;
use Mockery\MockInterface;
use ThinRepository\LambdaCondition;
use ThinRepositoryExamples\ExampleBuilder;
use ThinRepositoryTests\TestCase;

class LambaConditionTest extends TestCase {
  /**
   * @var MockInterface
   **/
  protected $builder;

  public function setUp() : void
  {
    parent::setUp();
    $this->builder = Mockery::mock(ExampleBuilder::class);
  }

  /**
   * @test
   **/
  public function applies_function_to_builder()
  {
    $this->builder->shouldReceive('hi')->with('cookies')->once();

    $condition = new LambdaCondition(function($builder) {
      $builder->hi('cookies');
    });

    $condition->apply($this->builder);
  }
}
