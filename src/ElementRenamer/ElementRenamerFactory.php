<?php

namespace ThinRepository\ElementRenamer;

use Illuminate\Support\Collection;

class ElementRenamerFactory {

  public function pushAndMake($value, &$arrayOrCollection)
  {
    if( $this->isCollection($arrayOrCollection) ) {
      return CollectionElementRenamer::pushAndCreate($value, $arrayOrCollection);
    }
    
    return ArrayElementRenamer::pushAndCreate($value, $arrayOrCollection);
  }

  private function isCollection($arrayOrCollection)
  {
    return $arrayOrCollection instanceof Collection;
  }

}
