<?php

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

        $params = sprintf('%s&%s/%s/%s', build_query_params(array(
                'getauth' => 1,
                'logout' => 1,
            ), $this->email, $passdigest, $digest);

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
