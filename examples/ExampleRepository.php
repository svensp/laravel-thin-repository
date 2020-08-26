<?php

namespace ThinRepositoryExamples;

use ThinRepository\ThinRepository;

class ExampleRepository {
  use ThinRepository;

  /**
   * @var ExampleModel
   **/
  protected $model;

  public function __construct(ExampleModel $model)
  {
    $this->model = $model;
  }

}
