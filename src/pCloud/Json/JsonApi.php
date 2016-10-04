<?php

namespace GlauberPortella\pCloud\Json;

use GlauberPortella\pCloud\Exception\AccessDeniedException;
use GlauberPortella\pCloud\Exception\ConnectionBrokenException;
use GlauberPortella\pCloud\Exception\DirectoryNotExistException;
use GlauberPortella\pCloud\Exception\InternalErrorException;
use GlauberPortella\pCloud\Exception\InternalUploadErrorException;
use GlauberPortella\pCloud\Exception\InvalidFileFolderNameException;
use GlauberPortella\pCloud\Exception\LoginFailedException;
use GlauberPortella\pCloud\Exception\LoginRequiredException;
use GlauberPortella\pCloud\Exception\TooManyLoginException;
use GlauberPortella\pCloud\Exception\UnknownException;
use GlauberPortella\pCloud\Exception\UserQuotaException;

abstract class JsonApi
{
    const GETDIGEST_ENDPOINT = 'https://api.pcloud.com/getdigest';
    const FILE_UPLOAD_ENDPOINT = 'https://api.pcloud.com/uploadfile';
    const USERINFO_ENDPOINT = 'https://api.pcloud.com/userinfo';
    
    protected $authenticationToken;

    public function throwException($code)
    {
        switch ($code) {
            case 1000:   // Log in required.
                throw new LoginRequiredException();
            case 2000:   // Log in failed.
                throw new LoginFailedException();
            case 2001:   // Invalid file/folder name.
                throw new InvalidFileFolderNameException();
            case 2003:   // Access denied. You do not have permissions to preform this operation.
                throw new AccessDeniedException();
            case 2005:   // Directory does not exist.
                throw new DirectoryNotExistException();
            case 2008:   // User is over quota.
                throw new UserQuotaException();
            case 2041:   // Connection broken.
                throw new ConnectionBrokenException();
            case 4000:   // Too many login tries from this IP address.
                throw new TooManyLoginException();
            case 5000:   // Internal error. Try again later.
                throw new InternalErrorException();
            case 5001:   // Internal upload error.
                throw new InternalUploadErrorException();
            default:
                throw new UnkonwnException();
        }
    }
}
