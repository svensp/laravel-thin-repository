<?php

namespace ThinRepository\ElementRenamer\Facade;

use Illuminate\Support\Facades\Facade;
use ThinRepository\ElementRenamer\ElementRenamerFactory;

class ElementRenamer extends Facade {

  protected static function getFacadeAccessor()
  {
    return ElementRenamerFactory::class;
  }
}
