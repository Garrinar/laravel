<?php

namespace Garrinar\Modules\Filesystem\Distributed;

use League\Flysystem\Util;
use Symfony\Component\Finder\Finder;
use League\Flysystem\Filesystem as FlySystem;

class Filesystem extends FlySystem
{
    /** @var  Adapter */
    protected $adapter;

    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @inheritdoc
     */
    public function put($path, $contents, array $config = [])
    {

        if (parent::put($path, $contents, $config)) {
            return $this->getAdapter()->getModel();
        } else {
            return false;
        }
    }


    public function write($path, $contents, array $config = [])
    {
        if (parent::write($path, $contents, $config)) {
            return $this->getAdapter()->getModel();
        } else {
            return false;
        }
    }

    public function update($path, $contents, array $config = [])
    {
        if (parent::update($path, $contents, $config)) {
            return $this->getAdapter()->getModel();
        } else {
            return false;
        }
    }


}
