<?php

namespace Garrinar\Modules\Filesystem\Distributed;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

/**
 * Class Model
 * @package Garrinar\Filesystem\Distributed
 *
 *
 * @property string $id
 * @property string $name
 * @property string $old_name
 * @property string $path
 * @property string $distributed_path
 */
class FilesystemModel extends EloquentModel
{

    protected $fillable = [
        'path',
        'name',
        'old_name',
        'distributed_path'
    ];

    /** @var  Adapter $adapter */
    public $adapter;

    /** @var Collection $savedFile */
    public $savedFile;


    public function __construct($adapter = [], array $attributes = [])
    {
        if ($adapter instanceof Adapter) {
            $this->adapter = $adapter;
        } else {
            $attributes = $adapter;
        }
        $this->setTable(ServiceProvider::$table);
        parent::__construct($attributes);
    }

}
