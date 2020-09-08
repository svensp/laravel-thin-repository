<?php

namespace ThinRepository\ElementRenamer;

use Illuminate\Support\Collection;

class ElementRenamerFactory {

  public function pushAndMake($value, $arrayOrCollection)
  {
    return ArrayElementRenamer::pushAndCreate($value, $arrayOrCollection);
  }
}
