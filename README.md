# laravel-thin-repository

thin repository tries to make it simple to extend the beatiful chaining of
conditions found in the laravel Eloquent querybuilder to a repository for this
model.

## Updating

- 1.0.0 -> 2.0.0: the condition and advancedCondition functions no longer take
    the name as parameter with a default value. They instead return an
    ElementRenamer which allows to specify a name via the `named` method.  
    Example: `$this->condition(function() {})->named('user');`

## Install

laravel thin repository is installed via composer

  composer install svensp/laravel-thin-repository

## Use

The core of laravel thi repository is the ThinRepository trait. It will give you
the following methods on your repository:

- public find() - findOrFail with the current conditions
- public get() - get with the current conditions
- protected condition(Closure $condition, string $name = null) - set a condition
    through a lambda function
- protected advancedCondition(Condition $condition, string $name = null) - set a
    condition through an object implementing the `Condition` interface

Conditions will stack unless given a name. Conditions with the same name will
override eachother.

```php
<?php

/**
 * An example Repository using the ThinRepository trait to do its work
 **/
class ExampleRepository {
  use ThinRepository\ThinRepository;

  protected $modelClassPath = ExampleModel::class;

  public function forUser($userId)
  {
    $this->condition(function($builder) use ($userId) {
      $builder->where('user_id', $userId);
    });
    return $this;
  }

}

$example = app(ExampleRepository::class)->forUser(5)->find();
$examples = app(ExampleRepository::class)->forUser(5)->get();
```

