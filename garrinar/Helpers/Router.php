<?php


namespace Garrinar\Helpers;


class Router
{

    /** @var  \Illuminate\Routing\Router */
    protected $router;

    public function __construct()
    {
        $this->router = \Illuminate\Support\Facades\Route::getFacadeRoot();
    }

    public function grid($controllers)
    {
        if (!is_array($controllers)) {
            $controllers = [$controllers];
        }
        return
            $this->router->group(
                [
                    'prefix' => 'grid'
                ], function (\Illuminate\Routing\Router $router) use ($controllers) {
                foreach ($controllers as $controller) {
                    $className = class_basename($controller);
                    $prefix = @explode('controller', mb_strtolower($className))[0];
                    /** @var $router */
                    $router->group([
                        'prefix' => $prefix,
                        'namespace' => 'Grids',
                    ], function (\Illuminate\Routing\Router $router) use ($className) {
                        $router->get('get', $className . '@get');
                        $router->get('filter', $className . '@filter');
                        $router->get('sort', $className . '@sort');
                    });
                }
            });
    }
}