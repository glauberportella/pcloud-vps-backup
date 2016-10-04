<?php

namespace GlauberPortella\pCloud\Exception;

class LoginRequiredException extends \Exception
{
    protected $code = 1000;
    protected $message = 'Log in required.';
}
