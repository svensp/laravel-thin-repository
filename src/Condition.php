<?php

namespace ThinRepository;

interface Condition {
  function apply($builder);
}
