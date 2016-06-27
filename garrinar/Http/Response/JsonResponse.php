<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 24.06.2016
 * Time: 8:59
 */

namespace Garrinar\Http\Response;


class JsonResponse extends \Illuminate\Http\JsonResponse
{
    public function __construct($content, $status, array $headers = [], $options = 0)
    {
        parent::__construct($content, $status, $headers, $options);
    }

}