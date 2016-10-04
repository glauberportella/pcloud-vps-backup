<?php

namespace GlauberPortella\pCloud\Exception;

class UnknownException extends \Exception
{
    protected $code = 9999;
    protected $message = 'Unknown exception.';
}
