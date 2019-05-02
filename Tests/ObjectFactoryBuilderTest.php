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
use Fxp\Component\DefaultValue\ObjectFactoryBuilder;
use Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface;
use Fxp\Component\DefaultValue\ObjectTypeExtensionInterface;
use Fxp\Component\DefaultValue\ObjectTypeInterface;
use Fxp\Component\DefaultValue\ResolvedObjectTypeFactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ObjectFactoryBuilderTest extends TestCase
{
    /**
     * @var ObjectFactoryBuilderInterface
     */
    protected $builder;

    protected function setUp(): void
    {
        $this->builder = new ObjectFactoryBuilder();
    }

    protected function tearDown(): void
    {
        $this->builder = null;
    }

    public function testSetResolvedObjectTypeFactory(): void
    {
        /** @var ResolvedObjectTypeFactoryInterface $typeFactory */
        $typeFactory = $this->getMockBuilder('Fxp\Component\DefaultValue\ResolvedObjectTypeFactoryInterface')->getMock();

        $builder = $this->builder->setResolvedTypeFactory($typeFactory);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtension(): void
    {
        /** @var ObjectExtensionInterface $ext */
        $ext = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectExtensionInterface')->getMock();

        $builder = $this->builder->addExtension($ext);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtensions(): void
    {
        $exts = [
            $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectExtensionInterface')->getMock(),
        ];

        $builder = $this->builder->addExtensions($exts);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddType(): void
    {
        /** @var ObjectTypeInterface $type */
        $type = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeInterface')->getMock();

        $builder = $this->builder->addType($type);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypes(): void
    {
        $types = [
            $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeInterface')->getMock(),
        ];

        $builder = $this->builder->addTypes($types);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtension(): void
    {
        /** @var ObjectTypeExtensionInterface $ext */
        $ext = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeExtensionInterface')->getMock();

        $builder = $this->builder->addTypeExtension($ext);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtensions(): void
    {
        $exts = [
            $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeExtensionInterface')->getMock(),
        ];

        $builder = $this->builder->addTypeExtensions($exts);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testGetObjectFactory(): void
    {
        /** @var ObjectTypeInterface $type */
        $type = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeInterface')->getMock();
        $this->builder->addType($type);

        $of = $this->builder->getObjectFactory();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactory', $of);
    }
}
