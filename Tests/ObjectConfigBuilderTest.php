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

use PHPUnit\Framework\TestCase;
use Sonatra\Component\DefaultValue\ObjectConfigBuilder;
use Sonatra\Component\DefaultValue\ObjectConfigBuilderInterface;
use Sonatra\Component\DefaultValue\ResolvedObjectType;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Object\Foobar;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooCompletType;
use Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectConfigBuilderTest extends TestCase
{
    /**
     * @var ObjectConfigBuilderInterface
     */
    protected $config;

    protected function setUp()
    {
        $options = array(
            'username' => 'foo',
            'password' => 'bar',
        );
        $rType = new ResolvedObjectType(new FooCompletType());

        $this->config = new ObjectConfigBuilder($options);
        $this->config->setType($rType);
    }

    protected function tearDown()
    {
        $this->config = null;
    }

    public function testGetObjectConfig()
    {
        $config = $this->config->getObjectConfig();

        $this->assertEquals($this->config, $config);
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testGetObjectConfigWithConfigLocked()
    {
        $this->config->getObjectConfig();

        $this->config->getObjectConfig();
    }

    public function testGetType()
    {
        $type = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $type);
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooCompletType', $type->getInnerType());
    }

    public function testSetType()
    {
        $type = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $type);
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooCompletType', $type->getInnerType());

        $rType = new ResolvedObjectType(new FooType());
        $config = $this->config->setType($rType);
        $type2 = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface', $type2);
        $this->assertInstanceOf('Sonatra\Component\DefaultValue\Tests\Fixtures\Type\FooType', $type2->getInnerType());
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testSetTypeWithConfigLocked()
    {
        $rType = new ResolvedObjectType(new FooType());

        $this->config->getObjectConfig();
        $this->config->setType($rType);
    }

    public function testGetOptions()
    {
        $opts = $this->config->getOptions();

        $this->assertInternalType('array', $opts);
    }

    public function testHasAndGetOption()
    {
        $this->assertTrue($this->config->hasOption('username'));
        $this->assertEquals('foo', $this->config->getOption('username', 'default value'));

        $this->assertTrue($this->config->hasOption('password'));
        $this->assertEquals('bar', $this->config->getOption('password', 'default value'));

        $this->assertFalse($this->config->hasOption('invalidProperty'));
        $this->assertEquals('default value', $this->config->getOption('invalidProperty', 'default value'));
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testSetInvalidData()
    {
        $this->config->setData(42);
    }

    public function testSetValidData()
    {
        $data = new User('root', 'p@ssword');
        $config = $this->config->setData($data);

        $this->assertEquals($this->config, $config);
        $this->assertEquals($data, $this->config->getData());
        $this->assertEquals(get_class($data), $this->config->getDataClass());
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testSetValidDataWithConfigLocked()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);
        $this->config->getObjectConfig();

        $this->config->setData($data);
    }

    public function testGetProperties()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);
        $properties = $this->config->getProperties();

        $this->assertInternalType('array', $properties);
        $this->assertCount(9, $properties);
    }

    public function testGetProperty()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);

        $this->assertTrue($this->config->hasProperty('username'));
        $this->assertTrue($this->config->hasProperty('password'));
        $this->assertFalse($this->config->hasProperty('foobar'));

        $this->assertEquals('root', $this->config->getProperty('username'));
        $this->assertTrue($this->config->getProperty('enabled'));
        $this->assertTrue($this->config->getProperty('bar'));
        $this->assertFalse($this->config->getProperty('foo'));
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testGetPropertyWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->config->getProperty('property');
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testGetInvalidProperty()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);

        $this->config->getProperty('invalidField');
    }

    public function testSetProperties()
    {
        $data = new Foobar();
        $data->setBar('hello world');
        $data->setCustomField('42');
        $this->config->setData($data);

        $this->assertEquals('hello world', $data->getBar());
        $this->assertEquals('42', $data->getCustomField());
        $this->assertFalse($this->config->getProperty('privateProperty'));

        $config = $this->config->setProperties(array(
                'bar' => 'value edited',
                'customField' => '21',
                'privateProperty' => true,
        ));

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertEquals('value edited', $data->getBar());
        $this->assertEquals('21', $data->getCustomField());
        $this->assertTrue($this->config->getProperty('privateProperty'));
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testSetPropertiesWithConfigLocked()
    {
        $data = new Foobar();
        $this->config->setData($data);
        $this->config->getObjectConfig();

        $this->config->setProperties(array(
            'bar' => 'value edited',
        ));
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testSetPropertiesWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->config->setProperties(array(
            'property' => 'value',
        ));
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\InvalidArgumentException
     */
    public function testSetPropertiesWithInvalidClassProperty()
    {
        $data = new Foobar();
        $this->config->setData($data);

        $this->config->setProperties(array(
            'invalidProperty' => 'value',
        ));
    }

    public function testSetProperty()
    {
        $data = new Foobar();
        $data->setBar('hello world');
        $this->config->setData($data);

        $this->assertEquals('hello world', $data->getBar());

        $config = $this->config->setProperty('bar', 'value edited');

        $this->assertInstanceOf('Sonatra\Component\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertEquals('value edited', $data->getBar());
    }

    /**
     * @expectedException \Sonatra\Component\DefaultValue\Exception\BadMethodCallException
     */
    public function testSetPropertyWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->config->setProperty('property', 'value');
    }
}
