<?php

namespace App\Http\Controllers {

    use App\Models\Api\Response;
    use App\Models\Api\Token;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesResources;

    class Controller extends BaseController
    {
        use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

        public function redirectToReceiveToken()
        {
            return $this->redirect()->action('Web\TokenController@get');
        }

        public function redirectToAuth(Token $token)
        {
            if(!$token->exists) {
                return $this->redirectToReceiveToken();
            } else {
                return $this->redirect()->action('Web\AuthFlowController@login', ['token' => $token->token]);
            }
        }

        public function jsonResponse($data = [], $status = 200)
        {
            return new Response($data, $status);
        }

        /**
         * @param null $data
         * @param int $status
         * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
         */
        public function response($data = null, $status = 200)
        {
            return
                $data
                    ? response($data, $status)
                    : response();
        }

        public function notImplemented()
        {
            abort(501);
        }

        public function view(Array $params = [])
        {

            $result = $this->initToken($params);
            if($result instanceof RedirectResponse) {
                return $result;
            }

            $action = $this->getRouter()->current()->getAction();
            $controllerAndAction = mb_strtolower(class_basename($action['controller']));
            $exp = explode('App\Http\Controllers\\', $action['namespace']);
            $exp = count($exp) > 1 ? $exp : [];
            $namespace = implode('.', explode('\\', mb_strtolower(end($exp))));

            $controller = explode('controller', $controllerAndAction);
            $action = substr($controller[1], 1);
            return view(trim($namespace . '.' . $controller[0] . '.' . $action, '.'), $params);
        }

        /**
         * @return \Illuminate\Routing\Redirector
         */
        public function redirect()
        {
            return redirect();
        }

        public function checkTokenAndReturnResponse($token = null, $response = null)
        {
            if ($token instanceof Token) {
                if (!$token->exists) {
                    return $this->redirect()->to('/');
                } else {
                    return $response;
                }
            } else {
                /** @var $token Token */
                $token = Token::findByToken($token);
            }

            if (!$token || !$token->isValid()) {
                return $this->redirect()->to('/');
            } else {
                return $response;
            }
        }

        private function initToken(&$params) {
            $currentRoute = $this->getRouter()->getCurrentRoute();
            if($currentRoute->hasParameter('token')) {
                /** @var Token $token */
                $token = $currentRoute->getParameter('token');
                if (!$token || !$token->exists) {
                    return $this->redirectToReceiveToken();
                }
                $params['token'] = $token;
                return true;
            } else {
                $params['token'] = '';
                return false;
            }
        }
    }
}
