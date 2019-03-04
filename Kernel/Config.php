<?php

namespace Supermetrics\Kernel;

use Supermetrics\Kernel\Abstraction\ConfigInterface;
use Supermetrics\Kernel\Exception\ConfigException;

/**
 * Class Config
 */
class Config implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @param string $configDirectory
     * @param array $extensions
     */
    public function getDirectoryConfigs(string $configDirectory, array $extensions = ['php'])
    {
        $config = [];

        $fsIterator = new \FilesystemIterator($configDirectory);
        /* @var \SplFileInfo $file */
        foreach ($fsIterator as $file)
        {
            if (!in_array($file->getExtension(), $extensions, true))
            {
                throw new \LogicException('Configs should be only in php format.');
            }

            $name = str_replace('.' . $file->getExtension(), '', $file->getFilename());

            $config[$name] = include $file->getPath() . DS . $file->getFilename();
        }

        $this->config = $config;
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws ConfigException
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->config))
        {
            throw new ConfigException('Config with key "' . $key . '"" not set.');
        }

        return $this->config[$key];
    }
}