<?php

namespace ThinRepository\ElementRenamer;

class ArrayElementRenamer implements ElementRenamer {

  /**
   * @var array
   **/
  private $array;

  private $key;

  /**
   * @var mixed
   **/
  private $value;

  public static function pushAndCreate($value, &$array)
  {
    $renamer = app(self::class);

    $array[] = $value;
    end($array);
    $renamer->key = key($array);
    $renamer->array = &$array;
    $renamer->value = $value;

    return $renamer;
  }

  public function named($name)
  {
    $this->removeOldEntry();

    $this->putRenamedEntry($name);
  }

  private function removeOldEntry()
  {
    unset($this->array[$this->key]);
  }

  private function putRenamedEntry($newName)
  {
    $this->array[$newName] = $this->value;
    $this->key = $newName;
  }
  
}
