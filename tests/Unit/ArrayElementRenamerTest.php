<?php

namespace ThinRepositoryTests\Unit;

use ThinRepository\ArrayElementRenamer\ArrayElementRenamer;
use ThinRepositoryTests\TestCase;

class ArrayElementRenamerTest extends TestCase {
  private $array;

  private $value;

  public function setUp() : void
  {
    parent::setUp();
    $this->array = [];
  }

  /**
   * @test
   **/
  public function can_rename_in_array()
  {
    $this->pushMove('cookies');

    $this->assertWasMoved();
  }

  /**
   * @test
   **/
  public function can_rename_object_in_array()
  {
    $this->pushMove(new stdClass);

    $this->assertWasMoved();
  }

  private function pushMove($value)
  {
    $this->value = $value;

    $renamer = ArrayElementRenamer::pushAndMakeRenamer($value, $this->array);
    $renamer->rename('newKey');
  }

  private function assertWasMoved()
  {
    $this->assertArrayHasKey('newKey', $this->array);
    $this->assertArrayNotHasKey(0, $this->array);
    $this->assertEquals($this->value, $this->array['newKey']);
  }
}
