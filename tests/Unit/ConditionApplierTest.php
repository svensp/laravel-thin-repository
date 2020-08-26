<?php

namespace ThinRepositoryTests\Unit;

use Closure;
use Mockery;
use Mockery\MockInterface;
use ThinRepository\Condition;
use ThinRepository\ConditionApplier;
use ThinRepository\LambdaCondition;
use ThinRepositoryExamples\ExampleBuilder;
use ThinRepositoryTests\TestCase;

class ConditionApplierTest extends TestCase {

  /**
   * @var ConditionApplier
   **/
  protected $conditionApplier;

  /**
   * @var ExampleBuilder
   **/
  protected $exampleBuilder;

  /**
   * @var MockInterface
   **/
  protected $builder;

  /**
   * @var Condition
   **/
  protected $condition1;

  /**
   * @var Condition
   **/
  protected $condition2;

  public function setUp() : void
  {
    parent::setUp();
    $this->conditionApplier = $this->app->make(ConditionApplier::class);
    $this->exampleBuilder = $this->app->make(ExampleBuilder::class);
  }

  /**
   * @test
   **/
  public function can_apply_to_builder()
  {
    $this->conditionApplier->apply($this->exampleBuilder);
    $this->assertTrue(true);
  }

  /**
   * @test
   **/
  public function can_take_condition()
  {
    $condition = Mockery::mock(Condition::class);
    $this->conditionApplier->condition($condition);
    $this->assertTrue(true);
  }

  /**
   * @test
   **/
  public function can_take_named_condition()
  {
    $condition = Mockery::mock(Condition::class);
    $this->conditionApplier->condition($condition, 'name');
    $this->assertTrue(true);
  }

  /**
   * @test
   **/
  public function conditions_are_applied_to_builder()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->once();
      $builder->shouldReceive('otherFunction')->with('other-argument')->once();
    });

    $this->addConditions();

    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function named_conditions_are_applied_to_builder()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->once();
      $builder->shouldReceive('otherFunction')->with('other-argument')->once();
    });

    $this->addConditions('1', '2');
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function named_condition_overiddes_other_with_same_name()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->never();
      $builder->shouldReceive('otherFunction')->with('other-argument')->once();
    });

    $this->addConditions('condition', 'condition');
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function conditions_reset_after_apply()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->once();
      $builder->shouldReceive('otherFunction')->with('other-argument')->once();
    });

    $this->addConditions();
    $this->applyConditions();

    $this->withBuilder(function(MockInterface $newBuilder) {
      $newBuilder->shouldReceive('someFunction')->never();
      $newBuilder->shouldReceive('otherFunction')->never();
    });
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function preserve_conditions_persist_after_apply()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->once();
      $builder->shouldReceive('otherFunction')->with('other-argument')->once();
    });

    $this->addConditions();
    $this->persistConditions();
    $this->applyConditions();

    $this->withBuilder(function(MockInterface $newBuilder) {
      $newBuilder->shouldReceive('someFunction')->with('some-argument')->once();
      $newBuilder->shouldReceive('otherFunction')->with('other-argument')->once();
    });
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function preserve_conditions_after_2nd_apply()
  {
    $this->withBuilder(function(MockInterface $builder) {
      $builder->shouldReceive('someFunction')->with('some-argument')->times(2);
      $builder->shouldReceive('otherFunction')->with('other-argument')->times(2);
    });

    $this->addConditions();
    $this->persistConditions();
    $this->applyConditions();
    $this->applyConditions();

    $this->withBuilder(function(MockInterface $newBuilder) {
      $newBuilder->shouldReceive('someFunction')->with('some-argument')->never();
      $newBuilder->shouldReceive('otherFunction')->with('other-argument')->never();
    });
    $this->applyConditions();
  }

  protected function applyConditions()
  {
    $this->conditionApplier->apply($this->builder);
  }

  protected function persistConditions()
  {
    $this->conditionApplier->persist();
  }

  protected function addConditions($name1 = null, $name2 = null)
  {
    $this->makeConditions();
    $this->conditionApplier
         ->condition($this->condition1, $name1)
         ->condition($this->condition2, $name2);
  }

  protected function makeConditions()
  {
    $this->condition1 = new LambdaCondition(function($builder) {
      $builder->someFunction('some-argument');
    });
    $this->condition2 = new LambdaCondition(function($builder) {
      $builder->otherFunction('other-argument');
    });
  }

  protected function withBuilder(Closure $expect = null)
  {
    if ($expect === null) {
      $expect = function() {};
    }

    $newBuilder = Mockery::mock();
    $expect($newBuilder);
    $this->replaceBuilder($newBuilder);
  }

  protected function replaceBuilder($newBuilder)
  {
    $this->builder = $newBuilder;
  }
}
