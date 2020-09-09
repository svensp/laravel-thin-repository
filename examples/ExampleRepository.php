<?php

namespace ThinRepositoryExamples;

use ThinRepository\ThinRepository;

/**
 * An example Repository using the ThinRepository trait to do its work
 **/
class ExampleRepository {
  use ThinRepository;

  protected $modelClassPath = ExampleModel::class;

  public function forMyself()
  {
    $this->condition(function($builder) {
      $builder->where('for_myself', 1);
    })->named('user');
    return $this;
  }

  public function forUser($userId)
  {
    $this->condition(function($builder) use ($userId) {
      $builder->where('for_user_id', $userId);
    })->named('user');
    return $this;
  }

  public function objectCondition($value)
  {
    $this->advancedCondition( new ExampleCondition($value) );
    
    return $this;
  }
}
