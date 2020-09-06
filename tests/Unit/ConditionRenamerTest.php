<?php

namespace ThinRepositoryTests\Unit;

use stdClass;
use ThinRepository\ConditionRenamer;
use ThinRepositoryTests\TestCase;

class ConditionRenamerTest extends TestCase {

  private $array;

  private $value;

  /**
   * @test
   **/
  public function can_rename_in_array()
  {
    $this->withArray();

    $this->pushMove('cookies');

    $this->assertWasMoved();
  }

  /**
   * @test
   **/
  public function can_rename_in_collection()
  {
    $this->withCollection();

    $this->pushMove('cookies');

    $this->assertWasMoved();
  }
  
  /**
   * @test
   **/
  public function can_rename_object_in_array()
  {
    $this->withArray();

    $this->pushMove(new stdClass);

    $this->assertWasMoved();
  }

  /**
   * @test
   **/
  public function can_rename_object_in_collection()
  {
    $this->withCollection();

    $this->pushMove(new stdClass);

    $this->assertWasMoved();
  }

  private function withArray()
  {
    $this->array = [];
  }

  private function withCollection()
  {
    $this->array = collect();
  }

  private function pushMove($value)
  {
    $this->value = $value;

    $renamer = ConditionRenamer::pushAndMakeRenamer($value, $this->array);
    $renamer->rename('newKey');
  }

  private function assertWasMoved()
  {
    $this->assertArrayHasKey('newKey', $this->array);
    $this->assertArrayNotHasKey(0, $this->array);
    $this->assertEquals($this->value, $this->array['newKey']);
  }
}
