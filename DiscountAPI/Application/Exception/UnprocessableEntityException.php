<?php

namespace DiscountAPI\Application\Exception;

use Exception;

class UnprocessableEntityException extends Exception
{
    protected $message;

    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}