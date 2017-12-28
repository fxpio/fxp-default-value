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

use Fxp\Component\DefaultValue\Extension\Core\Type\DefaultType;
use Fxp\Component\DefaultValue\ObjectFactoryInterface;
use Fxp\Component\DefaultValue\ObjectTypeInterface;
use Fxp\Component\DefaultValue\ResolvedObjectType;
use Fxp\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\FooType;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\UserType;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ResolvedObjectTypeTest extends TestCase
{
    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testClassUnexist()
    {
        $type = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectTypeInterface')->getMock();
        $type->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue('Fxp\Component\DefaultValue\Tests\Fixtures\Object\UnexistClass'));

        /* @var ObjectTypeInterface $type */
        new ResolvedObjectType($type);
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
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
        $this->assertInstanceOf('Fxp\Component\DefaultValue\ResolvedObjectTypeInterface', $rType->getParent());
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
        $factory = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectBuilderInterface', $builder);
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
        $factory = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectBuilderInterface', $builder);
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
