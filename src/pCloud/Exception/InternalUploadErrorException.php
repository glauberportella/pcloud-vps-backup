<?php

namespace GlauberPortella\pCloud\Exception;

class InternalUploadErrorException extends \Exception
{
    protected $code = 5001;
    protected $message = 'Internal upload error.';
}
