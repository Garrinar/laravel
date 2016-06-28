<?php


namespace Garrinar\Helpers;


use Illuminate\Routing\Route;

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
                    /** @var $router */
                    $router->group(['prefix' => mb_strtolower($className)], function (\Illuminate\Routing\Router $router) use ($className) {
                        $router->get('get', $className . '@get');
                        $router->post('filter', $className . '@filter');
                        $router->post('sort', $className . '@sort');
                    });
                }
            });
    }
}