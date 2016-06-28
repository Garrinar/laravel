<?php

namespace Garrinar\Helpers;

class Garrinar extends Singletone
{
    /**
     * @return Router
     */
    public function router()
    {
        return $this->get(Router::class);
    }
}

if (!function_exists('garrinar')) {
    function garrinar()
    {
        return Garrinar::getInstance();
    }
}