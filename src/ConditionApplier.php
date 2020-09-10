<?php

namespace ThinRepository;

use ThinRepository\ElementRenamer\ElementRenamerFactory;

class ConditionApplier {

  /**
   * @var Condition[]
   **/
  private $conditions = [];

  private $persist = false;

  /**
   * @var ElementRenamerFactory
   **/
  private $elementRenamerFactory;

  public function __construct(ElementRenamerFactory $elementRenamerFactory)
  {
    $this->conditions = [];
    $this->elementRenamerFactory = $elementRenamerFactory;
  }

  public function apply($builder)
  {
    foreach($this->conditions as $condition) {
      $condition->apply($builder);
    }
    
    $this->reset();
  }

  public function condition(Condition $condition)
  {
    $renamer = $this->elementRenamerFactory
                    ->pushAndMake($condition, $this->conditions);
    return $renamer;
  }

  public function remove($name)
  {
    unset($this->conditions[$name]);
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

