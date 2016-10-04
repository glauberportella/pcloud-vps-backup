<?php

namespace GlauberPortella\pCloud\Exception;

class DirectoryNotExistException extends \Exception
{
    protected $code = 2005;
    protected $message = 'Directory does not exist.';
}
