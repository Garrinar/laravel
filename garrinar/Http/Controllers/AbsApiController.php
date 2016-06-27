<?php

namespace App\Http\Controllers {

    use App\Http\Controllers\Controller;
    use App\Models\Api\Response;

    class AjaxController extends Controller
    {
        public function checkTokenAndReturnResponse($token = null, $response = null)
        {
            if (!$token instanceof Token && mb_strlen(trim($token)) > 0) {
                $token = Token::findByToken($token);
            }

            if (!$token || !$token->isValid()) {
                return $this->unauthorizedJsonResponse();
            }

            return $this->jsonResponse($response);
        }

        public function unauthorizedJsonResponse()
        {
            return $this->jsonResponse('Unauthorized', 401);
        }

        public function internalErrorJsonResponse()
        {
            return $this->jsonResponse('Internal server error', 500);
        }

        public function jsonResponse($data = [], $status = 200)
        {
            return new Response($data, $status);
        }


    }
}
