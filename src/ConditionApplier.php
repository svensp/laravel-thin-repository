<?php

namespace ThinRepository;

class ConditionApplier {

  /**
   * @var Condition[]
   **/
  protected $conditions = [];

  protected $persist = false;

  public function apply($builder)
  {
    foreach($this->conditions as $condition) {
      $condition->apply($builder);
    }
    
    $this->reset();
  }

  public function condition(Condition $condition, $name = null)
  {
    if($name === null) {
      $this->conditions[] = $condition;
      return $this;
    }

    $this->conditions[$name] = $condition;
    return $this;
  }

  public function persist()
  {
    $this->persist = true;
  }

  protected function reset()
  {
    if($this->persist) {
      $this->persist = false;
      return;
    }
    $this->conditions = [];
  }
}

