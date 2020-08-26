<?php

namespace ThinRepositoryExamples;

use ThinRepository\ThinRepository;

class ExampleRepository {
  use ThinRepository;

  /**
   * @var ExampleModel
   **/
  protected $exampleModel;

  public function __construct(ExampleModel $exampleModel)
  {
    $this->exampleModel = $exampleModel;
  }

}
