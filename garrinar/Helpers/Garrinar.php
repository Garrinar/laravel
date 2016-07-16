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

    /**
     * @return Env
     */
    public function env()
    {
        return $this->get(Env::class);
    }
}