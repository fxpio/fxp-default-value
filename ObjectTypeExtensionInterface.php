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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface ObjectTypeExtensionInterface
{
    /**
     * Builds the object default value.
     *
     * This method is called for each type in the hierarchy starting object the
     * top most type. Type extensions can further modify the object.
     *
     * @param ObjectBuilderInterface $builder The object builder
     * @param array                  $options The options
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Finishes the object.
     *
     * This method is called for each type in the hierarchy ending object the
     * top most type. Type extensions can further modify the object.
     *
     * @param ObjectBuilderInterface $builder The object builder
     * @param array                  $options The options
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Returns the class name of the type being extended.
     *
     * @return string The class name of the type being extended
     */
    public function getExtendedType();
}
