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

/**
 * A builder for ObjectFactoryInterface objects.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface ObjectFactoryBuilderInterface
{
    /**
     * Sets the factory for creating ResolvedObjectTypeInterface instances.
     *
     * @param ResolvedObjectTypeFactoryInterface $resolvedTypeFactory
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function setResolvedTypeFactory(ResolvedObjectTypeFactoryInterface $resolvedTypeFactory);

    /**
     * Adds an extension to be loaded by the factory.
     *
     * @param ObjectExtensionInterface $extension The extension
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addExtension(ObjectExtensionInterface $extension);

    /**
     * Adds a list of extensions to be loaded by the factory.
     *
     * @param array $extensions The extensions
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addExtensions(array $extensions);

    /**
     * Adds a object default value type to the factory.
     *
     * @param ObjectTypeInterface $type The object default value type
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addType(ObjectTypeInterface $type);

    /**
     * Adds a list of object default value types to the factory.
     *
     * @param array $types The object default value types
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addTypes(array $types);

    /**
     * Adds a object default value type extension to the factory.
     *
     * @param ObjectTypeExtensionInterface $typeExtension The object default value type extension
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addTypeExtension(ObjectTypeExtensionInterface $typeExtension);

    /**
     * Adds a list of object default value type extensions to the factory.
     *
     * @param array $typeExtensions The object default value type extensions
     *
     * @return ObjectFactoryBuilderInterface The builder
     */
    public function addTypeExtensions(array $typeExtensions);

    /**
     * Builds and returns the factory.
     *
     * @return ObjectFactoryInterface The object default value factory
     */
    public function getObjectFactory();
}
