<?php

namespace Garrinar\Http\Response\Neon;


use Garrinar\Http\Response\AjaxResponse as Response;

class LoginAjaxResponse extends Response
{

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
