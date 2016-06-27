<?php

namespace Garrinar\Http\Response;


class AjaxResponse extends JsonResponse
{

    /**
     * @param array $data
     * @return JsonResponse
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
