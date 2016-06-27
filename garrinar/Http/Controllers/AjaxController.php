<?php

namespace Garrinar\Http\Controllers {

    use App\Http\Controllers\Controller;
    use App\Models\Api\Response;

    class AjaxController extends Controller
    {
        public function unauthorizedResponse()
        {
            return $this->jsonResponse('Unauthorized', 401);
        }

        public function internalErrorResponse()
        {
            return $this->Response('Internal server error', 500);
        }

        public function response($data = [], $status = 200)
        {
            return new Response($data, $status);
        }
    }
}
