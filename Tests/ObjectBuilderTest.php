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

use Fxp\Component\DefaultValue\ObjectBuilder;
use Fxp\Component\DefaultValue\ObjectBuilderInterface;
use Fxp\Component\DefaultValue\ObjectFactoryInterface;
use Fxp\Component\DefaultValue\ResolvedObjectType;
use Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo;
use Fxp\Component\DefaultValue\Tests\Fixtures\Type\FooCompletType;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ObjectBuilderTest extends TestCase
{
    /**
     * @var ObjectBuilderInterface
     */
    protected $builder;

    protected function setUp()
    {
        $options = [
            'bar' => 'hello world',
        ];
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $type = new FooCompletType();
        $rType = new ResolvedObjectType($type);

        $this->builder = new ObjectBuilder($factory, $options);
        $this->builder->setType($rType);
    }

    protected function tearDown()
    {
        $this->builder = null;
    }

    public function testGetObjectFactory()
    {
        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectFactoryInterface', $this->builder->getObjectFactory());
    }

    public function testGetObjectWithoutData()
    {
        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testGetObjectWithoutDataWithEditionOnFinishMethod()
    {
        $options = [
            'bar' => 'the answer to life, the universe, and everything',
        ];
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Fxp\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $type = new FooCompletType();
        $rType = new ResolvedObjectType($type);

        $this->builder = new ObjectBuilder($factory, $options);
        $this->builder->setType($rType);

        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testGetObjectWithData()
    {
        $data = new Foo();
        $data->setBar('new value');
        $this->builder->setData($data);
        $instance = $this->builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('new value', $instance->getBar());
    }

    public function testGetObjectWithDataWithEditionOnFinishMethod()
    {
        $data = new Foo();
        $data->setBar('the answer to life, the universe, and everything');
        $this->builder->setData($data);
        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }
}
