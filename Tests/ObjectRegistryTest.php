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

use PHPUnit\Framework\TestCase;
use Sonatra\Component\DefaultValue\ObjectRegistry;
use Sonatra\Component\DefaultValue\ObjectRegistryInterface;
use Sonatra\Component\DefaultValue\ResolvedObjectTypeFactory;
use Sonatra\Component\DefaultValue\Tests\Fixtures\TestExtension;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectRegistryTest extends TestCase
{
    /**
     * @var ObjectRegistryInterface
     */
    protected $registry;

    protected function setUp()
    {
        $this->registry = new ObjectRegistry(array(
            new TestExtension(),
        ), new ResolvedObjectTypeFactory());
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testExtensionUnexpectedTypeException()
    {
        new ObjectRegistry(array(
            42,
        ), new ResolvedObjectTypeFactory());
    }

    public function testHasTypeObject()
    {
        $classname = 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User';
        $classname2 = 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\UnexistingType';

        $this->assertTrue($this->registry->hasType($classname));
        $this->assertTrue($this->registry->hasType($classname)); // uses cache in class
        $this->assertFalse($this->registry->hasType($classname2));
    }

    public function testGetTypeObject()
    {
        $classname = 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
    }

    public function testGetDefaultTypeObject()
    {
        $classname = 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\Foo';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\Extension\Core\Type\DefaultType', $resolvedType->getInnerType());
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testGetTypeObjectUnexpectedTypeException()
    {
        $this->registry->getType(42);
    }

    public function testGetExtensions()
    {
        $exts = $this->registry->getExtensions();
        $this->assertInternalType('array', $exts);
        $this->assertCount(1, $exts);
    }
}
