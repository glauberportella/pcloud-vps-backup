<?php

namespace GlauberPortell\pCloud\Json;

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
            thrown new \InvalidArgumentException('File to upload does not exist. You passed: "'.$filePath.'" to UploadFile::put().');

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
