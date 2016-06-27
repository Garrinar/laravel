<?php

namespace App\Models\Core;

use Carbon\Carbon;
use Garrinar\Filesystem\Distributed\Model;

/**
 * Class Files
 * @package App\Models\Core
 *
 *
 */
class Files extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'old_name',
        'path',
        'distributed_path',
        'created_at',
        'deleted_at',
    ];

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
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->getPublicPath() . '/' . $this->path;
    }
}