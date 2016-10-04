<?php

namespace GlauberPortella\pCloud\Exception;

class AccessDeniedException extends \Exception
{
    protected $code = 2003;
    protected $message = 'Access denied. You do not have permissions to preform this operation.';
}
