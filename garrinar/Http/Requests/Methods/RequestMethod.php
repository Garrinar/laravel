<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 24.06.2016
 * Time: 9:44
 */

namespace Garrinar\Http\Requests\Methods;


use Garrinar\Http\Requests\Request;

abstract class RequestMethod extends Request implements RequestMethodInterface
{
    public $isAllowed = true;

    public function allow()
    {
        $this->isAllowed = true;
    }

    public function disallow()
    {
        $this->isAllowed = false;
    }
}