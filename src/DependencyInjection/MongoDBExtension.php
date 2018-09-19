<?php

namespace Bacart\Bundle\MongoDBBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MongoDBExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $fileLocator = new FileLocator(\dirname(__DIR__).'/Resources/config');
        $loader = new XmlFileLoader($container, $fileLocator);

        $loader->load('services.xml');
    }
}
