<?php

namespace ThinRepositoryTests\Unit\ElementRenamer;

use stdClass;
use ThinRepository\ElementRenamer\ElementRenamer;
use ThinRepositoryTests\TestCase;

abstract class AbstractElementRenamerTest extends TestCase {

  const DEFAULT_VALUE = 'test';

  /**
   * @var array
   **/
  protected $arrayOrCollection;

  /**
   * @var ElementRenamer
   **/
  private $renamer;

  /**
   * @var string
   **/
  protected $renamerClass;

  abstract protected function makeArrayOrCollection();

  abstract protected function getInsertedArrayKey();

  /**
   * @test
   **/
  public function can_create_array_element_renamer()
  {
    $this->pushAndMakeRenamer();

    $this->assertInstanceOf($this->renamerClass, $this->renamer);
  }

  /**
   * @test
   **/
  public function push_appends_value_to_array()
  {
    $this->pushAndMakeRenamer();
    $key = $this->getInsertedArrayKey();
    $value = $this->arrayOrCollection[$key];

    $this->assertEquals(self::DEFAULT_VALUE, $value );
  }

  /**
   * @test
   **/
  public function removes_old_entry_on_rename()
  {
    $this->pushAndMakeRenamer();
    $firstKey = $this->getInsertedArrayKey();

    $this->renamer->named('test-key');

    $this->assertArrayNotHasKey($firstKey, $this->arrayOrCollection);
  }

  /**
   * @test
   **/
  public function can_rename_string()
  {
    $this->pushAndMakeRenamer();
    $firstKey = $this->getInsertedArrayKey();

    $this->renamer->named('test-key');

    $this->assertEntryWithKeyCreated(self::DEFAULT_VALUE, 'test-key');
  }

  /**
   * @test
   **/
  public function can_rename_object()
  {
    $object = new stdClass;
    $this->pushObjectAndMakeRenamer($object);

    $this->renamer->named('test-key');

    $this->assertEntryWithKeyCreated($object, 'test-key');
  }

  /**
   * @test
   **/
  public function can_rename_twice()
  {
    $object = new stdClass;
    $this->pushObjectAndMakeRenamer($object);

    $this->renamer->named('test-key');
    $this->renamer->named('renamed-key');

    $this->assertArrayNotHasKey('test-key', $this->arrayOrCollection);
    $this->assertEntryWithKeyCreated($object, 'renamed-key');
  }

  private function assertEntryWithKeyCreated($value, $key)
  {
    $this->assertArrayHasKey($key, $this->arrayOrCollection);
    $this->assertEquals($value, $this->arrayOrCollection[$key]);
    
  }

  protected function pushAndMakeRenamer()
  {
    $this->renamer =  $this->renamerClass::pushAndCreate(self::DEFAULT_VALUE, $this->arrayOrCollection);
  }
  
  protected function pushObjectAndMakeRenamer($object)
  {
    $this->renamer =  $this->renamerClass::pushAndCreate($object, $this->arrayOrCollection);
  }

  public function setUp() : void
  {
    parent::setUp();
    $this->makeArrayOrCollection();
  }
}
