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

use \Httpful\Request;

class UploadFile extends JsonApi
{
    public function __construct($authenticationToken)
    {
        $this->authenticationToken = $authenticationToken;
    }

    /**
     * Upload a file using the PUT method
     * @return array
     */
    public function put($filePath, array $params)
    {
        if (!file_exists($filePath))
            throw new \InvalidArgumentException('File to upload does not exist. You passed: "'.$filePath.'" to UploadFile::put().');

        if (!array_key_exists('filename', $params)) {
            $params['filename'] = basename($filePath);
        }

        $queryParams = http_build_query(array_merge($params, array('auth' => $this->authenticationToken)));
        $response = Request::put(JsonApi::FILE_UPLOAD_ENDPOINT.'?'.$queryParams)
            ->sendsJson()
            ->body(file_get_contents($filePath))
            ->send();

        if (!$response->hasBody())
            $this->throwException(9999);

        if ($response->body->result != 0)
            $this->throwException((int)$response->body->result);

        return $response->body->result;
    }
}
