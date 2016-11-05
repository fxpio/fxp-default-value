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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
abstract class AbstractTypeExtension implements ObjectTypeExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
