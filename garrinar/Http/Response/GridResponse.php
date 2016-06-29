<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 24.06.2016
 * Time: 8:59
 */

namespace Garrinar\Http\Response;


class GridResponse extends \Illuminate\Http\JsonResponse
{
    public function __construct($content = '', $status = self::HTTP_OK, array $headers = [], $options = 0)
    {
//        $headers['Access-Control-Allow-Origin'] = '*';
//        $headers['Access-Control-Allow-Methods'] = 'GET, POST, PUT, DELETE, OPTIONS';
        parent::__construct($content, $status, $headers, $options);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function setData($data = [])
    {
        $resp = [
            'status' => $this->getStatusCode() == 200 ? 'success' : 'error',
            'statusCode' => $this->getStatusCode(),
        ];
        return parent::setData(array_merge($data, $resp));
    }

}