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

use Fxp\Component\DefaultValue\ObjectExtensionInterface;
use Fxp\Component\DefaultValue\ObjectTypeExtensionInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractBaseExtensionTest extends TestCase
{
    /**
     * @var ObjectExtensionInterface
     */
    protected $extension;

    protected function setUp(): void
    {
        throw new \LogicException('The setUp() method must be overridden');
    }

    protected function tearDown(): void
    {
        $this->extension = null;
    }

    public function testHasType(): void
    {
        $this->assertTrue($this->extension->hasType('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User'));
        $this->assertFalse($this->extension->hasType('Foo'));
    }

    public function testHasTypeExtension(): void
    {
        $this->assertTrue($this->extension->hasTypeExtensions('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User'));
        $this->assertFalse($this->extension->hasTypeExtensions('Foo'));
    }

    public function testGetType(): void
    {
        $type = $this->extension->getType('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User');

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectTypeInterface', $type);
        $this->assertEquals('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User', $type->getClass());
    }

    public function testGetUnexistingType(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\InvalidArgumentException::class);

        $this->extension->getType('Foo');
    }

    public function testGetTypeExtension(): void
    {
        $exts = $this->extension->getTypeExtensions('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User');

        $this->assertInternalType('array', $exts);
        $this->assertCount(1, $exts);

        /** @var ObjectTypeExtensionInterface $ext */
        $ext = $exts[0];
        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectTypeExtensionInterface', $ext);
        $this->assertEquals('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User', $ext->getExtendedType());
    }
}
