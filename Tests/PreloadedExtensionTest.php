<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Tests;

use Sonatra\Component\DefaultValue\PreloadedExtension;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PreloadedExtensionTest extends AbstractBaseExtensionTest
{
    protected function setUp()
    {
        $types = array(
            'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User' => new UserType(),
        );
        $extensions = array(
            'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User' => array(new UserExtension()),
        );

        $this->extension = new PreloadedExtension($types, $extensions);
    }
}
