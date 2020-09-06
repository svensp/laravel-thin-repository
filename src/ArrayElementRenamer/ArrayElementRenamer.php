<?php

namespace ThinRepository\ArrayElementRenamer;

class ArrayElementRenamer implements ElementRenamer {

  public function rename($newName) {
  }
  
  public static function pushAndMakeRenamer($value, &$array)
  {
    $renamer = app(self::class);

    $array[] = $value;
    $renamer->array = $array;

    return $renamer;
  }
}
