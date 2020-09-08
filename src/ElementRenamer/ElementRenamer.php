<?php

namespace ThinRepository\ElementRenamer;

interface ElementRenamer {

  /**
   * Rename the created element to the given name
   **/
  public function named($name);
  
}
