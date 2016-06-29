<?php

if (!function_exists('garrinar')) {
    /**
     * @return \Garrinar\Helpers\Garrinar
     */
    function garrinar()
    {
        return \Garrinar\Helpers\Garrinar::getInstance();
    }
}