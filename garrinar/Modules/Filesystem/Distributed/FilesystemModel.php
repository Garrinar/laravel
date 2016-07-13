<?php

namespace Garrinar\Modules\Filesystem\Distributed;

use Carbon\Carbon;
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
 * @property $date_created
 * @property $date_updated
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

    protected $publicPath;

    /**
     *
     * @param string $fileName
     * @param string $fileContent
     *
     * @return self
     */
    public static function put($fileName, $fileContent = '')
    {
        $model = \Storage::put($fileName, $fileContent);
        return self::query()->find($model->id);
    }

    /**
     * Write data to file
     *
     * @param array $data
     * @return bool|int|void
     */
    public function putContent($data)
    {
        if(file_put_contents($this->getFilePath(), $data)) {
            $this->setUpdatedAt(Carbon::now()->toDateTimeString());
        }
        return $this->save();
    }

    public function getContent()
    {
        return @file_get_contents($this->getFilePath());
    }

    public static function getPublicPath()
    {
        return end(@explode(public_path(), config('filesystems.disks.public')['root']));
    }

    public function getFilePath()
    {
        return public_path(mb_substr($this->getPublicPath(), 1)) . '/' . $this->path;
    }

    public function getUrl()
    {
        if($this->exists) {
            return 'http://' . $_SERVER['HTTP_HOST'] . $this->getPublicPath() . '/' . $this->path;
        } else {
            return '';
        }
    }
}
