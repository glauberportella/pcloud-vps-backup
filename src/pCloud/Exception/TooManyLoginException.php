<?php

namespace GlauberPortella\pCloud\Exception;

class TooManyLoginException extends \Exception
{
    protected $code = 4000;
    protected $message = 'Too many login tries from this IP address.';
}
