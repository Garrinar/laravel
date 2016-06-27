<?php


namespace Garrinar\Http\Requests\Methods;
/**
 * Interface RequestMethodInterface
 * @package Garrinar\Http\Requests\Methods
 */
interface RequestMethodInterface
{
    public function send();

    public function setCrossOrigin();
    
    public function unsetCrossOrigin();

    public function allow();

    public function disallow();
}