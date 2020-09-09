<?php

namespace ThinRepositoryTests\Unit\ElementRenamer;

use ThinRepository\ElementRenamer\ArrayElementRenamer;

class ArrayElementRenamerTest extends AbstractElementRenamerTest {

  protected $renamerClass = ArrayElementRenamer::class;

  protected function makeArrayOrCollection()
  {
    $this->arrayOrCollection = [];
  }

  protected function getInsertedArrayKey()
  {
    reset($this->arrayOrCollection);
    return key( $this->arrayOrCollection );
  }
}
