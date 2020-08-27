<?php

namespace ThinRepositoryExamples;

use stdClass;

/**
 * This ExampleBuilder is a builder used for testing. It echoes the
 * structure of the Eloquent query builder with firstOrFail and get being the
 * relevant functions to get the result and 'where' setting values on the
 * returned object so the objects can be used in test assertions
 **/
class ExampleBuilder {

  protected $values = [];

  public function firstOrFail()
  {
    $object = new stdClass();

    $this->applyValues($object);
    $this->resetValues();

    return $object;
  }

  public function get()
  {
    $result = [];

    for($j=0 ; $j < 2; ++$j) {
      $newResult = new StdClass;

      $this->applyValues($newResult);

      $result[] = $newResult;
    }

    $this->resetValues();

    return $result;
  }

  public function where($name, $value)
  {
    $this->values[$name] = $value;
    return $this;
  }

  protected function applyValues(stdClass $stdClass)
  {
    foreach($this->values as $name => $value) {
      $stdClass->{$name} = $value;
    }
  }

  protected function resetValues()
  {
    $this->values = [];
  }
  
}
