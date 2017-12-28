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
use Fxp\Component\DefaultValue\Tests\Fixtures\TestExpectedExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\TestExtension;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class AbstractExtensionTest extends TestCase
{
    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testGetUnexistingType()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMockForAbstractClass('Fxp\Component\DefaultValue\AbstractExtension');
        $ext->getType('unexisting_type');
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testInitLoadTypeException()
    {
        $ext = new TestExpectedExtension();
        $ext->getType('unexisting_type');
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testInitLoadTypeExtensionException()
    {
        $ext = new TestExpectedExtension();
        $ext->getTypeExtensions('unexisting_type');
    }

    public function testGetEmptyTypeExtension()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMockForAbstractClass('Fxp\Component\DefaultValue\AbstractExtension');
        $typeExts = $ext->getTypeExtensions('unexisting_type_extension');

        $this->assertInternalType('array', $typeExts);
        $this->assertCount(0, $typeExts);
    }

    public function testGetType()
    {
        $ext = new TestExtension();
        $type = $ext->getType('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User');

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectTypeInterface', $type);
    }

    public function testHasType()
    {
        $ext = new TestExtension();

        $this->assertTrue($ext->hasType('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User'));
    }

    public function testGetTypeExtensions()
    {
        $ext = new TestExtension();
        $typeExts = $ext->getTypeExtensions('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User');

        $this->assertInternalType('array', $typeExts);
        $this->assertCount(1, $typeExts);
        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectTypeExtensionInterface', $typeExts[0]);
    }

    public function testHasTypeExtensions()
    {
        $ext = new TestExtension();

        $this->assertTrue($ext->hasTypeExtensions('Fxp\Component\DefaultValue\Tests\Fixtures\Object\User'));
    }
}
