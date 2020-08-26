<?php

namespace NotFound;

use ThinRepositoryExamples\ExampleBuilder;
use ThinRepositoryExamples\ExampleModel;
use ThinRepositoryTests\TestCase;

class ExampleModelTest extends TestCase {

  /**
   * @var ExampleModel
   **/
  protected $exampleModel;

  public function setUp(): void
  {
    parent::setUp();
    $this->exampleModel = $this->app->make(ExampleModel::class);
  }

  /**
   * @test
   **/
  public function query_returns_example_query()
  {
    $query = $this->exampleModel->query();

    $this->assertInstanceOf(ExampleBuilder::class, $query);
  }
}
