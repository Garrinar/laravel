<?php

namespace Garrinar\Http\Response;


class AjaxResponse extends JsonResponse
{

    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $headers['Access-Control-Allow-Origin'] = '*';
        $headers['Access-Control-Allow-Methods'] = 'GET, POST, PUT, DELETE, OPTIONS';
        parent::__construct($data, $status, $headers, $options);
    }

    /**
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setData($data = [])
    {
        $resp = [
            'status' => $this->getStatusCode() == 200 ? 'success' : 'error',
            'statusCode' => $this->getStatusCode(),
            'response' => $data,
        ];
        return parent::setData($resp);
    }
}
