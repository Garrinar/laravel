<?php
/**
 * Created by PhpStorm.
 * User: garrinar
 * Date: 24.05.16
 * Time: 18:56
 */

namespace Garrinar\Models\Eloquent;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class AbsBuilder
 * @package App\Models\Core
 *
 */
class Builder extends EloquentBuilder
{
    /**
     * @param array $columns
     * @return Model|Collection
     */
    public function first($columns = ['*'])
    {
        /** @var Model $result */
        return parent::first($columns);
    }

    /**
     * @param array $columns
     * @return Model|Collection
     */
    public function get($columns = ['*'])
    {
        return parent::get($columns);
    }

    /**
     * @param array $columns
     * @return static
     */
    public function select($columns = ['*'])
    {
        return parent::select($columns);
    }

    /**
     * @param $key
     * @param string $value
     * @return static
     */
    public function orderBy($key, $value = '')
    {
        return parent::orderBy($key, $value);
    }

    /**
     * @param $key
     * @return static
     */
    public function whereNull($key)
    {
        return parent::whereNull($key);
    }

    /**
     * @param $key
     * @param $value
     * @return static
     */
    public function groupBy($key, $value)
    {
        return parent::groupBy($key, $value);
    }

}