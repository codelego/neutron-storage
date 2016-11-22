<?php

namespace Phpfox\Storage;


class StorageManager implements StorageManagerInterface
{
    /**
     * @var StorageServiceInterface[]
     */
    protected $vars = [];

    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var string
     */
    protected $default;

    /**
     * @var ServiceFactoryInterface
     */
    protected $factory;

    /**
     * StorageManager constructor.
     *
     * @param $configs
     *
     * @throws StorageException
     */
    public function __construct($configs)
    {
        $this->map = $configs['map'];
        $this->factory = $configs['factory'];
        $this->default = $configs['default'];
    }

    public function get($id)
    {
        if (!$id) {
            $id = $this->default;
        }

        return $this->vars[$id] ? $this->vars[$id]
            : $this->vars[$id] = $this->factory->factory($this->map[$id]);
    }

    public function set($id, StorageServiceInterface $service)
    {
        $this->vars[$id] = $service;
        return $this;
    }

    public function has($id)
    {
        return isset($this->vars[$id]);
    }

    public function getUrl($id, $name)
    {
        return $this->get($id)->getUrl($name);
    }

    public function getPath($id, $name)
    {
        return $this->get($id)->getPath($name);
    }

    public function putFile($id, $local, $name)
    {
        return $this->get($id)->putFile($local, $name);
    }

    public function getFile($id, $local, $name)
    {
        return $this->get($id)->getFile($local, $name);
    }

    public function deleteFile($id, $name)
    {
        return $this->get($id)->deleteFile($name);
    }
}