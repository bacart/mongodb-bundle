<?php

namespace Bacart\Bundle\MongoDBBundle\DependencyInjection;

use Bacart\Bundle\MongoDBBundle\Storage\MongoDBStorage;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MongoDBExtension extends Extension
{
    protected const MONGODB_STORAGE_TAG = 'mongodb.storage';

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(MongoDBStorage::class)
            ->addTag(static::MONGODB_STORAGE_TAG);

        $fileLocator = new FileLocator(\dirname(__DIR__).'/Resources/config');
        $loader = new XmlFileLoader($container, $fileLocator);

        $loader->load('services.xml');
    }
}
