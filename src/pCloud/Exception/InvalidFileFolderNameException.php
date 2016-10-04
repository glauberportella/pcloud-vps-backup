<?php

namespace GlauberPortella\pCloud\Exception;

class InvalidFileFolderNameException extends \Exception
{
    protected $code = 2001;
    protected $message = 'Invalid file/folder name.';
}
