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
use Fxp\Component\DefaultValue\ObjectFactory;
use Fxp\Component\DefaultValue\ObjectFactoryInterface;
use Fxp\Component\DefaultValue\ObjectRegistry;
use Fxp\Component\DefaultValue\PreloadedExtension;
use Fxp\Component\DefaultValue\ResolvedObjectTypeFactory;
use Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\FooCompletType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ObjectFactoryTest extends TestCase
{
    /**
     * @var ObjectFactoryInterface
     */
    protected $factory;

    protected function setUp()
    {
        $exts = array(
            new PreloadedExtension(array(
                'default' => new DefaultType(),
                'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo' => new FooCompletType(),
            ), array()),
        );
        $registry = new ObjectRegistry($exts, new ResolvedObjectTypeFactory());

        $this->factory = new ObjectFactory($registry, new ResolvedObjectTypeFactory());
    }

    protected function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateBuilderWithObjectTypeInstance()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceWithSpecialValueOfBarField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, array('bar' => 'the answer to life, the universe, and everything'));
        $instance = $builder->getObject();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndData()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('has value');
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInFieldWithSpecialValueOfBarField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('the answer to life, the universe, and everything');
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testCreateBuilderWithObjectTypeInstanceWithoutOptions()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());

        $this->factory->createBuilder($type);
    }

    public function testCreateBuilderWithString()
    {
        $builder = $this->factory->createBuilder('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testCreateBuilderWithTypeIsNotAResolvedObjectTypeInstance()
    {
        $this->factory->createBuilder(42);
    }

    public function testCreateObject()
    {
        $instance = $this->factory->create('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateObjectWithData()
    {
        $data = new Foo();
        $data->setBar('has value');
        $instance = $this->factory->create('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $data, array('bar' => 'hello world'));

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testInjectDefaultValueInObject()
    {
        $data = new Foo();
        $instance = $this->factory->inject($data, array('bar' => 'hello world'));

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    /**
     * @expectedException \Fxp\Component\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testInjectDefaultValueInNonObject()
    {
        $this->factory->inject(42);
    }
}
