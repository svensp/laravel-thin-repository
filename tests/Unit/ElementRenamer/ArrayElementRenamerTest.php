<?php

namespace ThinRepositoryTests\Unit\ElementRenamer;

use stdClass;
use ThinRepository\ElementRenamer\ArrayElementRenamer;
use ThinRepositoryTests\TestCase;

class ArrayElementRenamerTest extends TestCase {

  const DEFAULT_VALUE = 'test';

  /**
   * @var array
   **/
  private $array;

  /**
   * @var ArrayElementRenamer
   **/
  private $renamer;

  public function setUp() : void
  {
    parent::setUp();
    $this->array = [];
  }

  /**
   * @test
   **/
  public function can_create_array_element_renamer()
  {
    $this->pushAndMakeRenamer();

    $this->assertInstanceOf(ArrayElementRenamer::class, $this->renamer);
  }

  /**
   * @test
   **/
  public function push_appends_value_to_array()
  {
    $this->pushAndMakeRenamer();
    $this->assertEquals(self::DEFAULT_VALUE, reset($this->array) );
  }

  /**
   * @test
   **/
  public function can_rename_string_in_array()
  {
    $this->pushAndMakeRenamer();
    $firstKey = $this->getInsertedArrayKey();

    $this->renamer->named('test-key');

    $this->assertArrayNotHasKey($firstKey, $this->array);
    $this->assertArrayHasKey('test-key', $this->array);
    $this->assertEquals(self::DEFAULT_VALUE, $this->array['test-key']);
  }

  /**
   * @test
   **/
  public function can_rename_object_in_array()
  {
    $object = new stdClass;
    $this->pushObjectAndMakeRenamer($object);
    $firstKey = $this->getInsertedArrayKey();

    $this->renamer->named('test-key');

    $this->assertArrayNotHasKey($firstKey, $this->array);
    $this->assertArrayHasKey('test-key', $this->array);
    $this->assertEquals($object, $this->array['test-key']);
  }

  private function pushAndMakeRenamer()
  {
    $this->renamer =  ArrayElementRenamer::pushAndCreate(self::DEFAULT_VALUE, $this->array);
  }

  private function pushObjectAndMakeRenamer($object)
  {
    $this->renamer =  ArrayElementRenamer::pushAndCreate($object, $this->array);
  }

  private function getInsertedArrayKey()
  {
    reset($this->array);
    return key( $this->array );
  }
}
