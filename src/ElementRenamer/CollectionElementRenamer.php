<?php

namespace ThinRepository\ElementRenamer;

class CollectionElementRenamer implements ElementRenamer {

  private $collection;

  private $key;

  private $value;


  public static function pushAndCreate($value, $collection)
  {
    $renamer = app(self::class);

    $renamer->collection = $collection;
    $renamer->value = $value;

    $collection->push($value);
    $renamer->key = $collection->keys()->last();

    return $renamer;
  }

  public function named($name)
  {
    $this->removeOldEntry();

    $this->putNewEntry($name);
  }

  private function removeOldEntry()
  {
    $this->collection->forget($this->key);
  }

  private function putNewEntry($newName)
  {
    $this->collection->put($newName, $this->value);
  }
  
}
