<?php

namespace ThinRepositoryTests\Feature;

use ThinRepositoryExamples\ExampleRepository;
use ThinRepositoryTests\TestCase;

class ThinRepositoryTest extends TestCase {

  /**
   * @var ExampleRepository
   **/
  protected $repository;

  /**
   * 
   **/
  protected $testModel;

  public function setUp() : void
  {
    parent::setUp();
    $this->repository = $this->app->make(ExampleRepository::class);
  }

  /**
   * @test
   **/
  public function dummy()
  {
    $this->assertTrue(true);
  }
}
