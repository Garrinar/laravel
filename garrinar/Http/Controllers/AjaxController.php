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
            return new Response($data, $status);
        }
    }
}
