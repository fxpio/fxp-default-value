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
 *
 * @internal
 */
final class ObjectFactoryTest extends TestCase
{
    /**
     * @var ObjectFactoryInterface
     */
    protected $factory;

    protected function setUp(): void
    {
        $exts = [
            new PreloadedExtension([
                'default' => new DefaultType(),
                'Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo' => new FooCompletType(),
            ], []),
        ];
        $registry = new ObjectRegistry($exts, new ResolvedObjectTypeFactory());

        $this->factory = new ObjectFactory($registry, new ResolvedObjectTypeFactory());
    }

    protected function tearDown(): void
    {
        $this->factory = null;
    }

    public function testCreateBuilderWithObjectTypeInstance(): void
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, ['bar' => 'hello world']);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceWithSpecialValueOfBarField(): void
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, ['bar' => 'the answer to life, the universe, and everything']);
        $instance = $builder->getObject();

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndData(): void
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $builder = $this->factory->createBuilder($type, $data, ['bar' => 'hello world']);
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInField(): void
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('has value');
        $builder = $this->factory->createBuilder($type, $data, ['bar' => 'hello world']);
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInFieldWithSpecialValueOfBarField(): void
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('the answer to life, the universe, and everything');
        $builder = $this->factory->createBuilder($type, $data, ['bar' => 'hello world']);
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceWithoutOptions(): void
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException::class);

        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());

        $this->factory->createBuilder($type);
    }

    public function testCreateBuilderWithString(): void
    {
        $builder = $this->factory->createBuilder('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', null, ['bar' => 'hello world']);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithTypeIsNotAResolvedObjectTypeInstance(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\UnexpectedTypeException::class);

        $this->factory->createBuilder(42);
    }

    public function testCreateObject(): void
    {
        $instance = $this->factory->create('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', null, ['bar' => 'hello world']);

        $this->assertInstanceOf('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateObjectWithData(): void
    {
        $data = new Foo();
        $data->setBar('has value');
        $instance = $this->factory->create('Fxp\Component\DefaultValue\Tests\Fixtures\Object\Foo', $data, ['bar' => 'hello world']);

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testInjectDefaultValueInObject(): void
    {
        $data = new Foo();
        $instance = $this->factory->inject($data, ['bar' => 'hello world']);

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testInjectDefaultValueInNonObject(): void
    {
        $this->expectException(\Fxp\Component\DefaultValue\Exception\UnexpectedTypeException::class);

        $this->factory->inject(42);
    }
}
