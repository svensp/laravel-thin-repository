<?php

namespace ThinRepositoryExamples;

class ExampleModel {
  /**
   * @return ExampleBuilder
   **/
  public function query()
  {
    return app(ExampleBuilder::class);
  }
}
