<?php

namespace Garrinar\Modules\Filesystem\Distributed;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Arr;
use Garrinar\Filesystem\Distributed\Adapter as DistributedAdapter;
use League\Flysystem\AdapterInterface;


class Manager extends FilesystemManager
{
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);
    }


    public function createLocalDriver(array $config)
    {
        $permissions = isset($config['permissions']) ? $config['permissions'] : [];
        $links = Arr::get($config, 'links') === 'skip'
            ? DistributedAdapter::SKIP_LINKS
            : DistributedAdapter::DISALLOW_LINKS;

        if (array_key_exists('distributed', $config)) {
            if ($config['distributed']) {
                return
                    $this->adapt(
                        $this->createDistributedFilesystem(
                            new DistributedAdapter(
                                $config['root'], LOCK_EX, $links, $permissions
                            ), $config)
                    );
            }
        }

        return parent::createLocalDriver($config);
    }

    /**
     * @param AdapterInterface $adapter
     * @param array $config
     * @return Filesystem
     */
    protected function createDistributedFilesystem(AdapterInterface $adapter, array $config)
    {
        $config = Arr::only($config, ['visibility']);

        return new Filesystem($adapter, count($config) > 0 ? $config : null);
    }
}