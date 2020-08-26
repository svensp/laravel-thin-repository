<?php

namespace ThinRepository;

trait ThinRepository {

  protected $model;

  public function find()
  {
    return $this->query()->firstOrFail();
  }

  public function get()
  {
    return $this->query()->get();
  }

  protected function query()
  {

    return $this->model->query();
  }

  protected function getModel()
  {
    if($this->model === null) {
      $this->model = $this->makeModel();
    }
  }
}
