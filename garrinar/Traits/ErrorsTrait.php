<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 08.04.2016
 * Time: 16:01
 */

namespace App\Traits;


trait ErrorsTrait
{
    private $errors = [];

    public function addError($key, $errorStr) {
        $this->errors[$key] = $errorStr;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }

    public function clearErrors() {
        $this->errors = [];
    }
}