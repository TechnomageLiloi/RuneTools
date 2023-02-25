<?php

namespace Liloi\Tools\Errors;

use Judex\ExtendedException;

class NotDefinedException extends ExtendedException
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $defaultMessage = 'Not defined exception.';

    /**
     * Exception code.
     *
     * @var int|string
     */
    protected $defaultCode = 0x201;
}