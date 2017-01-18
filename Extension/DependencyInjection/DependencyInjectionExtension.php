<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Extension\DependencyInjection;

use Sonatra\Component\DefaultValue\Exception\InvalidArgumentException;
use Sonatra\Component\DefaultValue\ObjectExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DependencyInjectionExtension implements ObjectExtensionInterface
{
    /**
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var array
     */
    protected $typeServiceIds;

    /**
     * @var array
     */
    protected $typeExtensionServiceIds;

    /**
     * Constructor.
     *
     * @param array $typeServiceIds
     * @param array $typeExtensionServiceIds
     */
    public function __construct(array $typeServiceIds, array $typeExtensionServiceIds)
    {
        $this->typeServiceIds = $typeServiceIds;
        $this->typeExtensionServiceIds = $typeExtensionServiceIds;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!isset($this->typeServiceIds[$name])) {
            throw new InvalidArgumentException(sprintf('The object default value type "%s" is not registered with the service container.', $name));
        }

        $type = $this->container->get($this->typeServiceIds[$name]);

        if ($type->getClass() !== $name) {
            throw new InvalidArgumentException(
                    sprintf('The object default value type class name specified for the service "%s" does not match the actual class name. Expected "%s", given "%s"',
                            $this->typeServiceIds[$name],
                            $name,
                            $type->getClass()
                    ));
        }

        return $type;
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return isset($this->typeServiceIds[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeExtensions($name)
    {
        $extensions = array();

        if (isset($this->typeExtensionServiceIds[$name])) {
            foreach ($this->typeExtensionServiceIds[$name] as $serviceId) {
                $extensions[] = $this->container->get($serviceId);
            }
        }

        return $extensions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTypeExtensions($name)
    {
        return isset($this->typeExtensionServiceIds[$name]);
    }
}
