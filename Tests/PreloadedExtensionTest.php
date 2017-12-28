<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests;

use Fxp\Component\DefaultValue\PreloadedExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PreloadedExtensionTest extends AbstractBaseExtensionTest
{
    protected function setUp()
    {
        $types = [
            'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User' => new UserType(),
        ];
        $extensions = [
            'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User' => [new UserExtension()],
        ];

        $this->extension = new PreloadedExtension($types, $extensions);
    }
}
