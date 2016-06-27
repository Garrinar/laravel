<?php

namespace Garrinar\Http\Response\Neon;


use Garrinar\Http\Response\JsonResponse as Response;

class LoginAjaxResponse extends Response
{
    public function __construct($content = '', $status = Response::HTTP_OK, array $headers = [], $options = 0)
    {
        parent::__construct($content, $status, $headers, $options);
    }


    /**
     * @param array $data
     * @return \Garrinar\Http\Response\JsonResponse
     */
    public function setData($data = [])
    {
        return parent::setData(
            array_merge(
                [
                    'login_status' =>
                        $this->getStatusCode() == Response::HTTP_OK
                            ? 'success'
                            : 'error'
                ],
                $data
            )
        );
    }
}
