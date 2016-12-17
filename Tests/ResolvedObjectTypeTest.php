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

use Sonatra\Component\DefaultValue\Extension\Core\Type\DefaultType;
use Sonatra\Component\DefaultValue\ObjectFactoryInterface;
use Sonatra\Component\DefaultValue\ObjectTypeInterface;
use Sonatra\Component\DefaultValue\ResolvedObjectType;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooType;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ResolvedObjectTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testClassUnexist()
    {
        $type = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectTypeInterface')->getMock();
        $type->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue('Sonatra\Component\DefaultValue\Tests\Fixtures\Object\UnexistClass'));

        /* @var ObjectTypeInterface $type */
        new ResolvedObjectType($type);
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testWrongExtensions()
    {
        $type = new UserType();

        new ResolvedObjectType($type, array('wrong_extension'));
    }

    public function testBasicOperations()
    {
        $parentType = new DefaultType();
        $type = new UserType();
        $rType = new ResolvedObjectType($type, array(new UserExtension()), new ResolvedObjectType($parentType));

        $this->assertEquals($type->getClass(), $rType->getClass());
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $rType->getParent());
        $this->assertEquals($type, $rType->getInnerType());

        $exts = $rType->getTypeExtensions();
        $this->assertInternalType('array', $exts);
        $this->assertCount(1, $exts);

        $options = $rType->getOptionsResolver();
        $this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolver', $options);
    }

    public function testInstanceBuilder()
    {
        $rType = $this->getResolvedType();
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectBuilderInterface', $builder);
        $this->assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        $this->assertInstanceOf($rType->getClass(), $instance);
        $this->assertEquals('test', $instance->getUsername());
        $this->assertEquals('password', $instance->getPassword());
    }

    public function testInstanceBuilderWithDefaultType()
    {
        $type = new FooType();
        $parentType = new DefaultType($type->getClass());
        $rType = new ResolvedObjectType($type, array(), new ResolvedObjectType($parentType));

        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Sonatra\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectBuilderInterface', $builder);
        $this->assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        $this->assertInstanceOf($rType->getClass(), $instance);
    }

    /**
     * Gets resolved type.
     *
     * @return ResolvedObjectType
     */
    private function getResolvedType()
    {
        $type = new UserType();
        $parentType = new DefaultType($type->getClass());

        return new ResolvedObjectType($type, array(new UserExtension()), new ResolvedObjectType($parentType));
    }
}
