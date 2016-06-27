<?php

namespace App\Models\Api {


    use App\Models\Core\AbsModel;
    use Illuminate\Routing\Router;

    class ApiTest extends AbsModel
    {
        protected
            $api,
            $router;

        public function __construct(Router $router, array $attributes = [])
        {
            $this->router = $router;
            $this->detectApi();
            parent::__construct($attributes);
        }

        /**
         * @return \Illuminate\Routing\RouteCollection
         */
        public function detectApi()
        {
            /** @var $router Router */
            $routes = $this->router->getRoutes();
            foreach ($routes as $route) {
                /** @var $route \Illuminate\Routing\Route */
                $action = $route->getAction();
                if (!starts_with($action['namespace'], 'App\Http\Controllers\Api') || $route->getPath() == 'api/test') {
                    continue;
                }
                $controllerAndAction = explode('@', $action['controller']);
                $reflectionClass = new \ReflectionClass($controllerAndAction[0]);
                $classShortName = end(@explode('App\Http\Controllers\Api\\', $controllerAndAction[0]));
                $className = explode('Controller', $classShortName)[0];
                $reflectionMethod = $reflectionClass->getMethod($controllerAndAction[1]);

                $phpdocClass = $reflectionClass->getDocComment();
                $this->api[$className]['phpDoc'] = self::filterPHPDoc($phpdocClass);
                $this->api[$className]['methods'][$reflectionMethod->getShortName()] = [
                    'phpDoc' => self::filterPHPDoc($reflectionMethod->getDocComment()),
                    'uri' => request()->getSchemeAndHttpHost() . '/' . $route->getPath(),
                    'method' => $route->getMethods()[0],
                    'action' => 'Api\\' . $classShortName . '@' . $reflectionMethod->getShortName(),
                    'params' => self::generateTestParamsByPHPDoc($reflectionMethod->getDocComment()),
                ];
            }

            return $routes;
        }

        public function getApi()
        {
            return $this->api;
        }
        
        private static function filterPHPDoc($phpDoc)
        {
            $phpDoc = preg_replace("/.*@package.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@dataParam.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@param.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@return.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@class.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@method.*/i", "", $phpDoc);
            $phpDoc = preg_replace("/.*@throws.*/i", "", $phpDoc);
            return
                trim(
                    str_replace(
                        ['/*', '*/', '*', '  ', "\n", "\t", '\Illuminate\Http\\'],
                        ['', '', '', '', '', '', ''],
                        $phpDoc
                    )
                );
        }

        private function generateTestParamsByPHPDoc($phpDoc)
        {
            $arPhpDoc = explode("\n", $phpDoc);
            $result = [];
            foreach ($arPhpDoc as $string) {
                if (str_contains($string, '* @dataParam ')) {
                    $expParam = explode(' ', explode('@dataParam', $string)[1]);

                    switch (count($expParam)) {
                        case 2:
                            if ($expParam[1] == 'string' || $expParam[1] == 'int' || $expParam[1] == 'integer' || $expParam[1] == 'file') {
                                $result[$expParam[2]] = 'test';
                            }
                            break;

                        case 3:
                            if ($expParam[1] == 'string' || $expParam[1] == 'file') {
                                $result[$expParam[2]] = 'test';
                            } elseif ($expParam[0] == 'int' || $expParam[0] == 'integer') {
                                $result[$expParam[2]] = 1;
                            }
                            break;

                        case 4:
                            if ($expParam[1] == 'string' || $expParam[0] == 'int' || $expParam[0] == 'integer' || $expParam[0] == 'file') {
                                $result[$expParam[2]] = $expParam[3];
                            }
                            $result[$expParam[2]] = $expParam[3];
                            break;

                        default:

                    }
                }
            }
            return $result;
        }
    }
}
