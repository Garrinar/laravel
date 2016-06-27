<?php

namespace Garrinar\Http\Controllers {


    use Illuminate\Routing\Controller;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesResources;

    class BaseController extends Controller
    {
        use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

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
    }
}
