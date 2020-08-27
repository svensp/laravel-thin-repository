<?php

namespace ThinRepositoryExamples;

use ThinRepository\Condition;

class ExampleCondition implements Condition {
  protected $value;

  public function __construct($value)
  {
    $this->value = $value;
  }
  
  public function apply($builder)
  {
    $builder->where('object_condition', $this->value);
  }
}
