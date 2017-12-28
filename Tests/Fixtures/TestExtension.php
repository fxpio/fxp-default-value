<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Fixtures;

use Fxp\Component\DefaultValue\AbstractExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\UserType;

/**
 * Test for extensions which provide types and type extensions.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TestExtension extends AbstractExtension
{
    protected function loadTypes()
    {
        return array(
            new UserType(),
        );
    }

    protected function loadTypeExtensions()
    {
        return array(
            new UserExtension(),
        );
    }
}
