<?php

namespace ThinRepository;

use Closure;

trait ThinRepository {

  protected $model;

  /**
   * @var ConditionApplier
   **/
  protected $conditionApplier;

  public function find()
  {
    return $this->query()->firstOrFail();
  }

  public function get()
  {
    return $this->query()->get();
  }

  protected function condition(Closure $closure)
  {
    $condition = new LambdaCondition($closure);
    return $this->advancedCondition($condition);
  }

  protected function advancedCondition(Condition $condition)
  {
    return $this->getConditionApplier()->condition($condition);
  }

  protected function query()
  {

    $query = $this->getModel()->query();

    $this->getConditionApplier()->apply($query);

    return $query;
  }

  protected function getModel()
  {
    if($this->model === null) {
      $this->model = $this->makeModel();
    }

    return $this->model;
  }

  protected function getConditionApplier()
  {
    if($this->conditionApplier === null) {
      $this->conditionApplier = $this->makeConditionApplier();
    }
    
    return $this->conditionApplier;
  }

  protected function makeModel()
  {
    $modelClassPathExists = isset($this->modelClassPath);
    assert($modelClassPathExists, 'No modelClassPath was set for the thin repository '.get_class($this));

    return app($this->modelClassPath);
  }

  protected function makeConditionApplier()
  {
    $conditionApplierClassPath = ConditionApplier::class;

    $conditionApplierClassPathIsOverriden = isset($this->conditionApplierClassPath);
    if($conditionApplierClassPathIsOverriden) {
      $conditionApplierClassPath = $this->conditionApplierClassPath;
    }

    return app($conditionApplierClassPath);
  }
}
