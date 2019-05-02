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

class FooType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options): void
    {
        // force the test to create instance with the default type
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo';
    }
}
