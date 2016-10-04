<?php

namespace GlauberPortella\pCloud\Exception;

class LoginFailedException extends \Exception
{
    protected $code = 2000;
    protected $message = 'Log in failed.';
}
