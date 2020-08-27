<?php

namespace ThinRepositoryExamples;

use ThinRepository\ThinRepository;

/**
 * An example Repository using the ThinRepository trait to do its work
 **/
class ExampleRepository {
  use ThinRepository;

  protected $modelClassPath = ExampleModel::class;

  public function forUser($userId)
  {
    $this->condition(function($builder) use ($userId) {
      $builder->where('for_user_id', $userId);
    });
    return $this;
  }

  public function objectCondition($value)
  {
    $this->advancedCondition( new ExampleCondition($value) );
    
    return $this;
  }
}
