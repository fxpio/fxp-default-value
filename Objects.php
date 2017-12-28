<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue;

use Fxp\Component\DefaultValue\Extension\Core\CoreExtension;

/**
 * Entry point of the Object Default Value component.
 *
 * Use this class to conveniently create new block factories:
 *
 * <code>
 * use Fxp\Component\DefaultValue\Objects;
 *
 * $objectFactory = Objects::createObjectFactory();
 *
 * $block = $objectFactory->create('Acme\DemoBundle\Entity\Post');
 * </code>
 *
 * You can also add custom extensions to the object default value factory:
 *
 * <code>
 * $objectFactory = Objects::createObjectFactoryBuilder()
 *     ->addExtension(new AcmeExtension())
 *     ->getObjectFactory();
 * </code>
 *
 * If you create custom object default value types or type extensions, it is
 * generally recommended to create your own extensions that lazily
 * load these types and type extensions. In projects where performance
 * does not matter that much, you can also pass them directly to the
 * object default value factory:
 *
 * <code>
 * $objectFactory = Objects::createObjectFactoryBuilder()
 *     ->addType(new PersonType())
 *     ->getObjectFactory();
 * </code>
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
final class Objects
{
    /**
     * Creates a object default value factory with the default configuration.
     *
     * @return ObjectFactoryInterface The object default value factory
     */
    public static function createObjectFactory()
    {
        return self::createObjectFactoryBuilder()->getObjectFactory();
    }

    /**
     * Creates a object default value factory builder with the default configuration.
     *
     * @return ObjectFactoryBuilderInterface The object default value factory builder
     */
    public static function createObjectFactoryBuilder()
    {
        $builder = new ObjectFactoryBuilder();
        $builder->addExtension(new CoreExtension());

        return $builder;
    }
}
