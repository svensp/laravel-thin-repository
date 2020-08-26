<?php

namespace ThinRepositoryExamples;

use stdClass;

class ExampleBuilder {

  protected $values = [];

  protected $amount = 0;

  public function find()
  {
    $object = new stdClass();

    $this->applyValues($object);
    $this->resetValues();

    return $object;
  }

  public function get()
  {
    $result = [];

    for($j=0 ; $j < $this->amount; ++$j) {
      $newResult = new StdClass;

      $this->applyValues($newResult);

      $result[] = $newResult;
    }

    $this->resetValues();

    return $result;
  }

  public function count($amount)
  {
    $this->amount = $amount;
    
    return $this;
  }

  public function set($name, $value)
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
