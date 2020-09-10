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
    $this->assertCount(2, $objects);
    $this->assertIsObject($objects[0]);
    $this->assertIsObject($objects[1]);
  }

  /**
   * @test
   **/
  public function can_set_user_id_through_find()
  {
    $result = $this->repository
                   ->forUser(5)
                   ->find();
    $this->assertForUserWasAppliedToResultWithId($result, 5);
  }

  /**
   * @test
   **/
  public function can_set_user_id_through_get()
  {
    $results = $this->repository
                    ->forUser(5)
                    ->get();
    $this->assertCount(2, $results);
    foreach($results as $result) {
      $this->assertForUserWasAppliedToResultWithId($result, 5);
    }
  }

  /**
   * @test
   **/
  public function can_use_object_condition_through_find()
  {
    $result = $this->repository
                   ->objectCondition(10)
                   ->find();
    $this->assertObjectHasAttribute('object_condition', $result);
    $this->assertEquals(10, $result->object_condition);
  }

  /**
   * @test
   **/
  public function can_use_object_condition_through_get()
  {
    $results = $this->repository
                    ->objectCondition(12)
                    ->get();
    $this->assertCount(2, $results);
    foreach($results as $result) {
      $this->assertObjectHasAttribute('object_condition', $result);
      $this->assertEquals(12, $result->object_condition);
    }
  }

  /**
   * @test
   **/
  public function can_override_conditions()
  {
    $result = $this->repository
                   ->forUser(12)
                   ->forMyself()
                   ->find();
    $this->assertNotForUserWasAppliedToResult($result);
    $this->assertForMyselfWasAppliedToResult($result);
  }

  private function assertForUserWasAppliedToResultWithId($result, $id)
  {
    $this->assertObjectHasAttribute('for_user_id', $result);
    $this->assertEquals($id, $result->for_user_id);
  }

  private function assertNotForUserWasAppliedToResult($result)
  {
    $this->assertObjectNotHasAttribute('for_user_id', $result);
  }

  private function assertForMyselfWasAppliedToResult($result)
  {
    $this->assertObjectHasAttribute('for_myself', $result);
    $this->assertEquals(1, $result->for_myself);
  }
}
