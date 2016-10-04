<?php
// Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

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
