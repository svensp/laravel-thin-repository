<?php

namespace NotFound;

use ThinRepositoryExamples\ExampleBuilder;
use ThinRepositoryTests\TestCase;

class ExampleBuilderTest extends TestCase {
  /**
   * @var ExampleBuilder
   **/
  protected $exampleBuilder;

  public function setUp() : void
  {
    parent::setUp();
    $this->exampleBuilder = $this->app->make(ExampleBuilder::class);
  }

  /**
   * @test
   **/
  public function find_returns_set_values()
  {
    $result = $this
      ->exampleBuilder
      ->set('cookies', 'yum')
      ->find();
    $this->assertEquals('yum', $result->cookies);
  }

  /**
   * @test
   **/
  public function next_find_does_not_return_old_values()
  {
    $this
      ->exampleBuilder
      ->set('cookies', 'yum')
      ->find();

    $result = $this
      ->exampleBuilder
      ->find();
    $this->assertObjectNotHasAttribute('cookies', $result);
  }

  /**
   * @test
   **/
  public function get_returns_expected_amount()
  {
    $result = $this
      ->exampleBuilder
      ->set('cookies', 'yum')
      ->count(2)
      ->get();
    $this->assertCount(2, $result);
  }

  /**
   * @test
   **/
  public function get_set_values_on_all_results()
  {
    $result = $this
      ->exampleBuilder
      ->set('cookies', 'yum')
      ->count(2)
      ->get();

    foreach($result as $object) {
      $this->assertEquals('yum', $object->cookies);
    }
  }

  /**
   * @test
   **/
  public function next_get_does_not_set_values_on_all_results()
  {
    $result = $this
      ->exampleBuilder
      ->set('cookies', 'yum')
      ->count(2)
      ->get();

    $result = $this
      ->exampleBuilder
      ->count(2)
      ->get();

    foreach($result as $object) {
      $this->assertObjectNotHasAttribute('cookies', $object);
    }
  }
}
