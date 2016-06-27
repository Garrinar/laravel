<?php

namespace Garrinar\Modules\Filesystem\Distributed;


use Garrinar\Modules\Filesystem\Distributed\Commands\CreateFilesTable;
use Garrinar\Modules\Filesystem\Distributed\Manager as FilesystemManager;
use Illuminate\Filesystem\FilesystemServiceProvider;

class ServiceProvider extends FilesystemServiceProvider
{
    public static $table = 'files';

    public function boot()
    {
        $this->commands([
            CreateFilesTable::class
        ]);
    }

    /**
     * Register the filesystem manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('filesystem', function () {
            return new FilesystemManager($this->app, $this->app['config']['filesystem']['distributed']['table'] ?: 'files');
        });
    }
}