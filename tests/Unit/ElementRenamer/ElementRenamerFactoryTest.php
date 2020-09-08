<?php

namespace ThinRepositoryTests\Unit\ElementRenamer;

use ThinRepository\ElementRenamer\ArrayElementRenamer;
use ThinRepository\ElementRenamer\ElementRenamerFactory;
use ThinRepositoryTests\TestCase;

class ElementRenamerFactoryTest extends TestCase {
  /**
   * @var ElementRenamerFactory
   **/
  private $renamerFactory;

  public function setUp() : void
  {
    parent::setUp();
    $this->renamerFactory = app(ElementRenamerFactory::class);
  }

  /**
   * @test
   **/
  public function creates_array_renamer_for_array()
  {
    $value = 'something';
    $array = [];

    $renamer = $this->renamerFactory->pushAndMake($value, $array);
    $this->assertInstanceOf(ArrayElementRenamer::class, $renamer);
  }
}
