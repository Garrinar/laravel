<?php

namespace Garrinar\Http\Controllers {

    use Garrinar\Http\Response\AjaxResponse as Response;

    class AjaxController extends BaseController
    {
        public function unauthorizedResponse()
        {
            return $this->response('Unauthorized', 401);
        }

        public function internalErrorResponse()
        {
            return $this->response('Internal server error', 500);
        }

        public function response($data = [], $status = Response::HTTP_OK)
        {
            $response = [
                'response' => $data,
                'status' => $status == Response::HTTP_OK ? 'success ' : 'error',
                'statusCode' => $status
            ];
            return new Response($response, $status);
        }
    }
}
