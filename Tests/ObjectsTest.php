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

use Fxp\Component\DefaultValue\Objects;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ObjectsTest extends TestCase
{
    public function testObjectFactoryBuilderCreator(): void
    {
        $of = Objects::createObjectFactoryBuilder();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $of);
    }

    public function testObjectFactoryCreator(): void
    {
        $of = Objects::createObjectFactory();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryInterface', $of);
    }
}
