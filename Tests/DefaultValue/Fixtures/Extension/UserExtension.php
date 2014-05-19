<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractTypeExtension;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface;

class UserExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {

    }

    public function getExtendedType()
    {
        return 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User';
    }
}
