<?php

namespace ThinRepository;

use Closure;

class LambdaCondition implements Condition {
  /**
   * @var Closure
   **/
  protected $do;

  public function __construct(Closure $do)
  {
    $this->do = $do;
  }

  public function apply($builder) {
    $do = $this->do;
    $do($builder);
  }
}
