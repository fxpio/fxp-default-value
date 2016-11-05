<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Tests\Fixtures\Extension;

use Sonatra\Component\DefaultValue\AbstractTypeExtension;

class UserExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User';
    }
}
