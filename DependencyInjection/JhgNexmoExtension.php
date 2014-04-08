<?php
namespace Jhg\NexmoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JhgNexmoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('jhg_nexmo.api_key', $config['api_key']);
        $container->setParameter('jhg_nexmo.api_secret', $config['api_secret']);
        $container->setParameter('jhg_nexmo.api_method', $config['api_method']);
        $container->setParameter('jhg_nexmo.disable_delivery', $config['disable_delivery']);
        $container->setParameter('jhg_nexmo.delivery_phone', $config['delivery_phone']);
        $container->setParameter('jhg_nexmo.from_name', $config['from_name']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
