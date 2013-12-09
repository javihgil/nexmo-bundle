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

        if (!isset($config['api_key'])) {
        	throw new \InvalidArgumentException('The "api_key" option must be set for JhgNexmoBundle');
        }

        if (!isset($config['api_secret'])) {
        	throw new \InvalidArgumentException('The "api_secret" option must be set for JhgNexmoBundle');
        }
        
        $container->setParameter('jhg_nexmo.api_key', $config['api_key']);
        $container->setParameter('jhg_nexmo.api_secret', $config['api_secret']);
        
        if(isset($config['disable_delivery'])) {
        	$container->setParameter('jhg_nexmo.disable_delivery', $config['disable_delivery']);
        }
        
        if(isset($config['from_name'])) {
        	if (strlen($config['from_name'])>11) {
        		throw new \InvalidArgumentException('The "jhg_nexmo.from_name" option can not be larger than 11 characters');
        	}
        	
        	if (!preg_match('/^[0-9a-z]{11}$/i', $config['from_name'])) {
        		throw new \InvalidArgumentException('The "jhg_nexmo.from_name" option only have alphanumeric characters');
        	}
        	
        	$container->setParameter('jhg_nexmo.from_name', $config['from_name']);
        } else {
        	$container->setParameter('jhg_nexmo.from_name', 'MyAppName');
        }
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
