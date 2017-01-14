<?php
namespace IMT\BehatProfilingExtension;

use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Extension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'profiling';
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('use_env')
                    ->defaultNull()
                    ->cannotBeEmpty()
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $container->setParameter('profiling.use_env', $config['use_env']);

        $useEnv = $container->getParameter('profiling.use_env');

        if (null === $useEnv || 'true' === getenv($useEnv)) {
            $container->setDefinition(
                'imt.behat_profiling_extension.stopwatch',
                new Definition('Symfony\Component\Stopwatch\Stopwatch')
            );

            $container->setDefinition(
                'imt.behat_profiling_extension.output',
                new Definition('Symfony\Component\Console\Output\ConsoleOutput')
            );

            $definition = new Definition(
                'IMT\BehatProfilingExtension\Listener\StopwatchListener',
                [
                    new Reference('imt.behat_profiling_extension.stopwatch'),
                    new Reference('imt.behat_profiling_extension.output')
                ]
            );
            $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG);

            $container->setDefinition('imt.behat_profiling_extension.listener.stopwatch', $definition);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }
}
