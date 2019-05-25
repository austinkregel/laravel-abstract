<?php

namespace Kregel\LaravelAbstract\Exceptions;

use Throwable;

class ModelNotInstanceOfAbstractEloquentModel extends \RuntimeException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct("The model provided is not an instance of the AbstractEloquentModel from the kregel/abstract package.", $code, $previous);
    }
}
