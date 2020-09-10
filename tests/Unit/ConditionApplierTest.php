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
    $this->conditionApplier->condition($condition)->named('name');
    $this->assertTrue(true);
  }

  /**
   * @test
   **/
  public function conditions_are_applied_to_builder()
  {
    $this->withBuilder();
    $this->addAnonymousConditions();

    $this->expectCondtionFunctionsCalledTimes(1);
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function named_conditions_are_applied_to_builder()
  {
    $this->withBuilder();
    $this->addNamedConditions('1', '2');

    $this->expectCondtionFunctionsCalledTimes(1);
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

    $this->addNamedConditions('condition', 'condition');
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function conditions_reset_after_apply()
  {
    $this->withBuilder();
    $this->addAnonymousConditions();

    $this->expectCondtionFunctionsCalledTimes(1);
    $this->applyConditions();

    $this->expectCondtionFunctionsNeverCalled();
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function preserve_conditions_persist_after_apply()
  {
    $this->withBuilder();
    $this->addAnonymousConditions();
    $this->persistConditions();

    $this->expectCondtionFunctionsCalledTimes(2);
    $this->applyConditions();
    $this->applyConditions();
  }

  /**
   * @test
   **/
  public function preserve_conditions_after_2nd_apply()
  {
    $this->withBuilder();
    $this->addAnonymousConditions();
    $this->persistConditions();

    $this->expectCondtionFunctionsCalledTimes(2);
    $this->applyConditions();
    $this->applyConditions();

    $this->expectCondtionFunctionsNeverCalled();
    $this->applyConditions();
  }

  public function can_reset_named_condition()
  {
    $this->withBuilder();
    $this->addNamedConditions('test1', 'test2');
    $this->persistConditions();

    $this->expectCondtionFunctionsCalledTimes(2);
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

  protected function addNamedConditions(string $name1, string $name2)
  {
    $this->makeConditions();
    $this->conditionApplier
         ->condition($this->condition1)->named($name1);
    $this->conditionApplier
         ->condition($this->condition2)->named($name2);
  }

  protected function addAnonymousConditions()
  {
    $this->makeConditions();
    $this->conditionApplier
         ->condition($this->condition1);
    $this->conditionApplier
         ->condition($this->condition2);
  }

  private function expectCondtionFunctionsCalledTimes($times)
  {
    $this->builder->shouldReceive('someFunction')->with('some-argument')->times($times);
    $this->builder->shouldReceive('otherFunction')->with('other-argument')->times($times);
  }

  private function expectCondtionFunctionsNeverCalled()
  {
    $this->builder->shouldReceive('someFunction')->with('some-argument')->never();
    $this->builder->shouldReceive('otherFunction')->with('other-argument')->never();
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
