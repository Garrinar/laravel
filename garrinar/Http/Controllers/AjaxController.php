<?php

namespace Garrinar\Http\Controllers {

    use Garrinar\Http\Response\AjaxResponse as Response;

    class AjaxController extends BaseController
    {
        public function unauthorizedResponse()
        {
            return $this->jsonResponse('Unauthorized', 401);
        }

        public function internalErrorResponse()
        {
            return $this->response('Internal server error', 500);
        }

        public function response($data = [], $status = 200)
        {
            return new Response($data, $status);
        }
    }
}
