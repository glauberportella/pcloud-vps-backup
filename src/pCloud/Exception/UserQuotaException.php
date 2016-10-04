<?php

namespace GlauberPortella\pCloud\Exception;

class UserQuotaException extends \Exception
{
    protected $code = 2008;
    protected $message = 'User is over quota.';
}
