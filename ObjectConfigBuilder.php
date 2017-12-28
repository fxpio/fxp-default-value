<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue;

use Fxp\Component\DefaultValue\Exception\BadMethodCallException;
use Fxp\Component\DefaultValue\Exception\InvalidArgumentException;

/**
 * A basic object default value configuration.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ObjectConfigBuilder implements ObjectConfigBuilderInterface
{
    /**
     * @var bool
     */
    protected $locked = false;

    /**
     * @var ResolvedObjectTypeInterface
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var array
     */
    protected $methods;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $options;

    /**
     * Creates an empty object default value configuration.
     *
     * @param array $options The object default value options
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProperty($name)
    {
        return in_array($name, $this->properties);
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($name)
    {
        if (null === $this->data) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed when the data is empty.');
        }

        $methodGet = 'get'.ucfirst($name);
        $methodHas = 'has'.ucfirst($name);
        $methodIs = 'is'.ucfirst($name);

        if (in_array($methodGet, $this->methods)) {
            return $this->getData()->$methodGet();
        }

        if (in_array($methodHas, $this->methods)) {
            return $this->getData()->$methodHas();
        }

        if (in_array($methodIs, $this->methods)) {
            return $this->getData()->$methodIs();
        }

        if (!$this->hasProperty($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" property does not exist on the "%s" class.', $name, $this->getDataClass()));
        }

        $ref = $this->findReflectionProperty($name, new \ReflectionClass($this->getData()));

        return $ref->getValue($this->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataClass()
    {
        return $this->dataClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        return $this->hasOption($name) ? $this->options[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(ResolvedObjectTypeInterface $type)
    {
        if ($this->locked) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed anymore once the builder is turned into a BlockConfigInterface instance.');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        if ($this->locked) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed anymore once the builder is turned into a BlockConfigInterface instance.');
        }

        if (!is_object($data)) {
            throw new InvalidArgumentException(sprintf('The data of object default value must be an object, given %s.', gettype($data)));
        }

        $this->data = $data;
        $this->dataClass = get_class($data);
        $this->methods = get_class_methods($data);
        $this->properties = array();
        $this->findProperties(new \ReflectionClass($data));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProperty($name, $value)
    {
        $this->setProperties(array($name => $value));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProperties(array $properties)
    {
        if (null === $this->data) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed when the data is empty.');
        }

        if ($this->locked) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed anymore once the builder is turned into a BlockConfigInterface instance.');
        }

        $refClass = new \ReflectionClass($this->getData());

        foreach ($properties as $property => $value) {
            $methodSet = 'set'.ucfirst($property);

            if (in_array($methodSet, $this->methods)) {
                $this->getData()->$methodSet($value);
            } else {
                $refProp = $this->findReflectionProperty($property, $refClass);
                $refProp->setValue($this->getData(), $value);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectConfig()
    {
        if ($this->locked) {
            throw new BadMethodCallException('BlockConfigBuilder methods cannot be accessed anymore once the builder is turned into a BlockConfigInterface instance.');
        }

        $this->locked = true;

        return $this;
    }

    /**
     * Finds all properties in class.
     *
     * @param \ReflectionClass $reflection
     */
    protected function findProperties(\ReflectionClass $reflection)
    {
        if (false !== $reflection->getParentClass()) {
            $this->findProperties($reflection->getParentClass());
        }

        $this->properties = array_unique(array_merge($this->properties, array_keys($reflection->getDefaultProperties())));
    }

    /**
     * Finds the reflection property.
     *
     * @param string           $property
     * @param \ReflectionClass $reflection
     *
     * @return \ReflectionProperty
     *
     * @throws InvalidArgumentException When the property is not found
     */
    protected function findReflectionProperty($property, \ReflectionClass $reflection)
    {
        if ($reflection->hasProperty($property)) {
            $refProp = $reflection->getProperty($property);
            $refProp->setAccessible(true);

            return $refProp;
        }

        if (false !== $reflection->getParentClass()) {
            return $this->findReflectionProperty($property, $reflection->getParentClass());
        }

        throw new InvalidArgumentException(sprintf('The "%s" property is not found in "%s" class.', $property, $this->getDataClass()));
    }
}
