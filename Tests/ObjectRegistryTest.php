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
 *
 * @internal
 */
final class ObjectRegistryTest extends TestCase
{
    /**
     * @var ObjectRegistryInterface
     */
    protected $registry;

    protected function setUp(): void
    {
        $this->registry = new ObjectRegistry([
            new TestExtension(),
        ], new ResolvedObjectTypeFactory());
    }

    public function testExtensionUnexpectedTypeException(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\UnexpectedTypeException::class);

        new ObjectRegistry([
            42,
        ], new ResolvedObjectTypeFactory());
    }

    public function testHasTypeObject(): void
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
        $classname2 = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\UnexistingType';

        $this->assertTrue($this->registry->hasType($classname));
        $this->assertTrue($this->registry->hasType($classname)); // uses cache in class
        $this->assertFalse($this->registry->hasType($classname2));
    }

    public function testGetTypeObject(): void
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
    }

    public function testGetDefaultTypeObject(): void
    {
        $classname = 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Extension\Core\Type\DefaultType', $resolvedType->getInnerType());
    }

    public function testGetTypeObjectUnexpectedTypeException(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\UnexpectedTypeException::class);

        $this->registry->getType(42);
    }

    public function testGetExtensions(): void
    {
        $exts = $this->registry->getExtensions();
        $this->assertInternalType('array', $exts);
        $this->assertCount(1, $exts);
    }
}
