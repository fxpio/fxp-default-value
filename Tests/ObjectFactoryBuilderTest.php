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

use Sonatra\Component\DefaultValue\ObjectExtensionInterface;
use Sonatra\Component\DefaultValue\ObjectFactoryBuilder;
use Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface;
use Sonatra\Component\DefaultValue\ObjectTypeExtensionInterface;
use Sonatra\Component\DefaultValue\ObjectTypeInterface;
use Sonatra\Component\DefaultValue\ResolvedObjectTypeFactoryInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectFactoryBuilderInterface
     */
    protected $builder;

    protected function setUp()
    {
        $this->builder = new ObjectFactoryBuilder();
    }

    protected function tearDown()
    {
        $this->builder = null;
    }

    public function testSetResolvedObjectTypeFactory()
    {
        /* @var ResolvedObjectTypeFactoryInterface $typeFactory */
        $typeFactory = $this->getMockBuilder('Sonatra\Component\DefaultValue\ResolvedObjectTypeFactoryInterface')->getMock();

        $builder = $this->builder->setResolvedTypeFactory($typeFactory);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtension()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectExtensionInterface')->getMock();

        $builder = $this->builder->addExtension($ext);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtensions()
    {
        $exts = array(
            $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectExtensionInterface')->getMock(),
        );

        $builder = $this->builder->addExtensions($exts);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddType()
    {
        /* @var ObjectTypeInterface $type */
        $type = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeInterface')->getMock();

        $builder = $this->builder->addType($type);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypes()
    {
        $types = array(
            $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeInterface')->getMock(),
        );

        $builder = $this->builder->addTypes($types);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtension()
    {
        /* @var ObjectTypeExtensionInterface $ext */
        $ext = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeExtensionInterface')->getMock();

        $builder = $this->builder->addTypeExtension($ext);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtensions()
    {
        $exts = array(
            $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeExtensionInterface')->getMock(),
        );

        $builder = $this->builder->addTypeExtensions($exts);

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testGetObjectFactory()
    {
        /* @var ObjectTypeInterface $type */
        $type = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeInterface')->getMock();
        $this->builder->addType($type);

        $of = $this->builder->getObjectFactory();

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectFactory', $of);
    }
}
