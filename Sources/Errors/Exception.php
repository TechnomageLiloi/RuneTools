<?php

namespace Liloi\Tools\Errors;

use Judex\ExtendedException;

class Exception extends ExtendedException
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $defaultMessage = 'Rune tools general exception.';

    /**
     * Exception code.
     *
     * @var int|string
     */
    protected $defaultCode = 0x200;
}