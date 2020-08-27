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
      ->where('cookies', 'yum')
      ->firstOrFail();
    $this->assertEquals('yum', $result->cookies);
  }

  /**
   * @test
   **/
  public function next_find_does_not_return_old_values()
  {
    $this
      ->exampleBuilder
      ->where('cookies', 'yum')
      ->firstOrFail();

    $result = $this
      ->exampleBuilder
      ->firstOrFail();
    $this->assertObjectNotHasAttribute('cookies', $result);
  }

  /**
   * @test
   **/
  public function get_returns_expected_amount()
  {
    $result = $this
      ->exampleBuilder
      ->where('cookies', 'yum')
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
      ->where('cookies', 'yum')
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
      ->where('cookies', 'yum')
      ->get();

    $result = $this
      ->exampleBuilder
      ->get();

    foreach($result as $object) {
      $this->assertObjectNotHasAttribute('cookies', $object);
    }
  }
}
