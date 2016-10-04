<?php

namespace GlauberPortella\pCloud\Exception;

class InternalErrorException extends \Exception
{
    protected $code = 5000;
    protected $message = 'Internal error. Try again later.';
}
