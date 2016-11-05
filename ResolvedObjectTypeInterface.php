<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue;

/**
 * A wrapper for a object default value type and its extensions.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface ResolvedObjectTypeInterface
{
    /**
     * Returns the class name of the type.
     *
     * @return string The type name
     */
    public function getClass();

    /**
     * Returns the parent type.
     *
     * @return ResolvedObjectTypeInterface The parent type or null
     */
    public function getParent();

    /**
     * Returns the wrapped object default value type.
     *
     * @return ObjectTypeInterface The wrapped object default value type
     */
    public function getInnerType();

    /**
     * Returns the extensions of the wrapped object default value type.
     *
     * @return ObjectTypeExtensionInterface[] An array of {@link ObjectTypeExtensionInterface} instances
     */
    public function getTypeExtensions();

    /**
     * Creates a new object default value builder for this type.
     *
     * @param ObjectFactoryInterface $factory The object default value factory
     * @param array                  $options The builder options
     *
     * @return ObjectBuilderInterface The created object default value builder
     */
    public function createBuilder(ObjectFactoryInterface $factory, array $options = array());

    /**
     * Constructs a new object instance.
     *
     * @param ObjectBuilderInterface $builder The builder to configure
     * @param array                  $options The builder options
     *
     * @return object The new object instance
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options);

    /**
     * Configures a object default value builder for the type hierarchy.
     *
     * @param ObjectBuilderInterface $builder The builder to configure
     * @param array                  $options The options used for the configuration
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Finishes a object default value builder for the type hierarchy.
     *
     * @param ObjectBuilderInterface $builder The builder to configure
     * @param array                  $options The options used for the configuration
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Returns the configured options resolver used for this type.
     *
     * @return \Symfony\Component\OptionsResolver\OptionsResolverInterface The options resolver
     */
    public function getOptionsResolver();
}
