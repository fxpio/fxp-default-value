<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Fixtures\Type;

use Fxp\Component\DefaultValue\AbstractType;
use Fxp\Component\DefaultValue\ObjectBuilderInterface;
use Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooCompletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options): void
    {
        /** @var Foo $data */
        $data = $builder->getData();

        if (null === $data->getBar()) {
            $data->setBar($options['bar']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options): void
    {
        /** @var Foo $data */
        $data = $builder->getData();

        if ('the answer to life, the universe, and everything' === $data->getBar()) {
            $data->setBar('42');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'bar' => null,
        ]);

        $resolver->addAllowedTypes('bar', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo';
    }
}
