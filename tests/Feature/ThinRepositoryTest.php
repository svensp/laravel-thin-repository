<?php

namespace ThinRepositoryTests\Feature;

use ThinRepositoryExamples\ExampleRepository;
use ThinRepositoryTests\TestCase;

class ThinRepositoryTest extends TestCase {

  /**
   * @var ExampleRepository
   **/
  protected $repository;

  public function setUp() : void
  {
    parent::setUp();
    $this->repository = $this->app->make(ExampleRepository::class);
  }

  /**
   * @test
   **/
  public function can_find_object()
  {
    $object = $this->repository->find();
    $this->assertIsObject($object);
  }

  /**
   * @test
   **/
  public function can_get_objects()
  {
    $objects = $this->repository->get();
    $this->assertCount(1, $objects);
    $this->assertIsObject($objects[0]);
  }

}
