<?php

namespace GlauberPortella\pCloud\Exception;

class ConnectionBrokenException extends \Exception
{
    protected $code = 2041;
    protected $message = 'Connection broken.';
}
