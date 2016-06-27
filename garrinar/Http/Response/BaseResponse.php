<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 24.06.2016
 * Time: 8:59
 */

namespace Garrinar\Http\Response;


use Illuminate\Http\Response;

class BaseResponse extends Response
{
    protected $isCrossOriginAllowed = false;

    protected $allowedRequestMethods = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'OPTIONS',
    ];

    public function __construct($content, $status, array $headers = [])
    {
        parent::__construct($content, $status, $headers);
    }

    public function allowCrossOrigin()
    {
        $this->isCrossOriginAllowed = true;
        $this->headers['Access-Control-Allow-Origin'] = '*';
        $this->headers['Access-Control-Allow-Methods'] = $this->getAllowedRequestMethodsString();
    }

    public function disallowCrossOrigin()
    {
        $this->isCrossOriginAllowed = false;
        unset(
            $this->headers['Access-Control-Allow-Origin'],
            $this->headers['Access-Control-Allow-Methods']
        );
    }

    public function getAllowedRequestMethodsString()
    {
        return trim(implode(', ', $this->getAllowedRequestMethodsString()));
    }

    public function setAllowMethod($allow = true)
    {
//        $this->allowedRequestMethods
    }
}