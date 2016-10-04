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

class DigestAuth extends JsonApi
{
    private $email;

    private $pass;

    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }

    public function getToken()
    {
        $digest = $this->getDigest();
        $passdigest = sha1($this->pass . sha1(strtolower($this->email)) . $digest);

        $params = http_build_query(array(
                'getauth' => 1,
                'logout' => 1,
                'username' => $this->email,
                'digest' => $digest,
                'passworddigest' => $passdigest,
            ));

        $response = Request::get(JsonApi::USERINFO_ENDPOINT . '?' . $params)
            ->sendsJson()
            ->send();

        if (!$response->hasBody())
            $this->throwException(9999);

        if ($response->body->result != 0)
            $this->throwException((int)$response->body->result);

        return $response->body->auth;
    }

    protected function getDigest()
    {
        $response = Request::get(JsonApi::GETDIGEST_ENDPOINT)
            ->sendsJson()
            ->send();

        if (!$response->hasBody())
            $this->throwException(9999);

        if ($response->body->result != 0)
            $this->throwException((int)$response->body->result);

        return $response->body->digest;
    }
}
