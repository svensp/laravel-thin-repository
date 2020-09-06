<?php

namespace ThinRepository;

use Illuminate\Support\Collection;

class ConditionRenamer {

  private $key;

  private $value;

  private $array;

  public static function putAndMakeRenamer($key, $value, &$array)
  {
    $conditionRenamer = app(self::class);

    $array[$key] = $value;
    $conditionRenamer->key = $key;
    $conditionRenamer->value = $value;
    $conditionRenamer->array = &$array;

    return $conditionRenamer;
  }

  public static function pushAndMakeRenamer($value, &$array)
  {
    $conditionRenamer = app(self::class);

    $key = self::pushAndReturnKey($value, $array);

    $conditionRenamer->key = $key;
    $conditionRenamer->value = $value;
    $conditionRenamer->array = &$array;

    return $conditionRenamer;
  }

  private static function pushAndReturnKey($value, $array)
  {
    if($array instanceof Collection) {
      return $array->keys()->last();
    }

    $array[] = $value;
    end($array);
    $key = key($array);
    return $key;
  }

  public function rename($newName)
  {
    $this->forgetOldEntry();

    $this->putNewEntry($newName);
  }

  private function forgetOldEntry()
  {
    if($this->array instanceof Collection) {
      $this->array->forget($this->key);
      return;
    }

    unset($this->array[$this->key]);
  }

  private function putNewEntry($newName)
  {
    $this->array[$newName] = $this->value;
  }
  
}
