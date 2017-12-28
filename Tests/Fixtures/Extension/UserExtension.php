<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Fixtures\Extension;

use Fxp\Component\DefaultValue\AbstractTypeExtension;

class UserExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
    }
}
