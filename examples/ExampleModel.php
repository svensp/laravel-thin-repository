<?php

namespace ThinRepositoryExamples;

/**
 * The only thing this example model does is provide the query method used to
 * return an instance of ExampleBuilder
 * In Laravel you'd use any model extending Eloquent
 **/
class ExampleModel {
  /**
   * @return ExampleBuilder
   **/
  public function query()
  {
    return app(ExampleBuilder::class);
  }
}
