<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Extension\DependencyInjection;

use Fxp\Component\DefaultValue\Extension\DependencyInjection\DependencyInjectionExtension;
use Fxp\Component\DefaultValue\ObjectTypeExtensionInterface;
use Fxp\Component\DefaultValue\ObjectTypeInterface;
use Fxp\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo;
use Fxp\Component\DefaultValue\Tests\Fixtures\Object\User;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\FooType;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\UserType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class DependencyInjectionExtensionTest extends TestCase
{
    /**
     * @var DependencyInjectionExtension
     */
    protected $ext;

    /**
     * @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $container;

    protected function setUp(): void
    {
        $fooType = new FooType();
        $userType = new UserType();
        $userExt = new UserExtension();

        $typeServiceIds = [
            $userType->getClass() => 'service.user.type',
            $fooType->getClass() => 'service.foo.type',
        ];
        $typeExtensionServiceIds = [
            $userExt->getExtendedType() => [
                'service.user.type_extension',
            ],
        ];

        $this->container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $this->ext = new DependencyInjectionExtension($typeServiceIds, $typeExtensionServiceIds);
        $this->ext->container = $this->container;
    }

    public function testGetType(): void
    {
        $this->container->expects($this->once())
            ->method('get')
            ->with('service.foo.type')
            ->will($this->returnValue(new FooType()))
        ;

        $this->assertTrue($this->ext->hasType(Foo::class));
        $type = $this->ext->getType(Foo::class);

        $this->assertInstanceOf(ObjectTypeInterface::class, $type);
    }

    public function testGetInvalidType(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/The object default value type "([\\w\\\\]+)" is not registered with the service container./');

        $this->ext->getType(\stdClass::class);
    }

    public function testGetInvalidClass(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/The object default value type class name specified for the service "([\\w\\.\\_]+)" does not match the actual class name. Expected "([\\w\\\\]+)", given "([\\w\\\\]+)"/');

        $this->container->expects($this->once())
            ->method('get')
            ->with('service.foo.type')
            ->will($this->returnValue(new UserType()))
        ;

        $this->assertTrue($this->ext->hasType(Foo::class));
        $this->ext->getType(Foo::class);
    }

    public function testHasType(): void
    {
        $this->assertTrue($this->ext->hasType(Foo::class));
        $this->assertFalse($this->ext->hasType(\stdClass::class));
    }

    public function testGetTypeExtensions(): void
    {
        $this->container->expects($this->once())
            ->method('get')
            ->with('service.user.type_extension')
            ->will($this->returnValue(new UserExtension()))
        ;

        $this->assertTrue($this->ext->hasTypeExtensions(User::class));
        $typeExtensions = $this->ext->getTypeExtensions(User::class);

        $this->assertCount(1, $typeExtensions);
        $this->assertInstanceOf(ObjectTypeExtensionInterface::class, current($typeExtensions));
    }

    public function testHasTypeExtensions(): void
    {
        $this->assertTrue($this->ext->hasTypeExtensions(User::class));
        $this->assertFalse($this->ext->hasTypeExtensions(\stdClass::class));
    }
}
