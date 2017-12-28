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

use Fxp\Component\DefaultValue\ObjectRegistry;
use Fxp\Component\DefaultValue\ObjectRegistryInterface;
use Fxp\Component\DefaultValue\ResolvedObjectTypeFactory;
use Fxp\Component\DefaultValue\Tests\Fixtures\TestExtension;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
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
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testExtensionUnexpectedTypeException()
    {
        new ObjectRegistry(array(
            42,
        ), new ResolvedObjectTypeFactory());
    }

    public function testHasTypeObject()
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
        $classname2 = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\UnexistingType';

        $this->assertTrue($this->registry->hasType($classname));
        $this->assertTrue($this->registry->hasType($classname)); // uses cache in class
        $this->assertFalse($this->registry->hasType($classname2));
    }

    public function testGetTypeObject()
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
    }

    public function testGetDefaultTypeObject()
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Extension\Core\Type\DefaultType', $resolvedType->getInnerType());
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
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
