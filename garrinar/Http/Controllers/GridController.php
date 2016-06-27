<?php

namespace Garrinar\Http\Controllers {
    

    abstract class GridController extends AjaxController
    {
        public $perPage = 15;

        abstract function get();

        abstract function filter();

        abstract function sort();
    }
}
