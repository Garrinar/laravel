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