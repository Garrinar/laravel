<?php

namespace Garrinar\Http\Controllers {


    use Illuminate\Routing\Controller;

    class BaseController extends Controller
    {

        public function view(Array $params = [])
        {
            $action = $this->getRouter()->current()->getAction();
            $controllerAndAction = mb_strtolower(class_basename($action['controller']));
            $exp = explode('App\Http\Controllers\\', $action['namespace']);
            $exp = count($exp) > 1 ? $exp : [];
            $namespace = implode('.', explode('\\', mb_strtolower(end($exp))));

            $controller = explode('controller', $controllerAndAction);
            $action = substr($controller[1], 1);
            return view(trim($namespace . '.' . $controller[0] . '.' . $action, '.'), $params);
        }

        public function response($data = null, $status = 200)
        {
            return
                $data
                    ? response($data, $status)
                    : response();
        }

        /**
         * @return \Illuminate\Routing\Redirector
         */
        public function redirect()
        {
            return redirect();
        }

        public function jsonResponse($data = [], $status = 200)
        {
            $response = [
                'response' => $data,
                'status' => $status == 200 ? 'success ' : 'error',
                'statusCode' => $status
            ];
            return $this->response()->json($response, $status);
        }
    }
}
