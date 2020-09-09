<?php

namespace ThinRepositoryTests\Unit\ElementRenamer;

use ThinRepository\ElementRenamer\CollectionElementRenamer;

class CollectionElementRenamerTest extends AbstractElementRenamerTest {

  protected $renamerClass = CollectionElementRenamer::class;

  protected function makeArrayOrCollection()
  {
    $this->arrayOrCollection = collect();
  }

  protected function getInsertedArrayKey()
  {
    return $this->arrayOrCollection->keys()->last();
  }

  
}
