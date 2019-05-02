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

use Fxp\Component\DefaultValue\Exception\InvalidArgumentException;
use Fxp\Component\DefaultValue\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A wrapper for a object default value type and its extensions.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ResolvedObjectType implements ResolvedObjectTypeInterface
{
    /**
     * @var ObjectTypeInterface
     */
    protected $innerType;

    /**
     * @var ObjectTypeExtensionInterface[]
     */
    protected $typeExtensions;

    /**
     * @var ResolvedObjectTypeInterface
     */
    protected $parent;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * Constructor.
     *
     * @param ObjectTypeInterface            $innerType
     * @param ObjectTypeExtensionInterface[] $typeExtensions
     * @param ResolvedObjectTypeInterface    $parent
     *
     * @throws InvalidArgumentException When the object default value type classname does not exist
     * @throws UnexpectedTypeException  When unexpected type of argument
     */
    public function __construct(ObjectTypeInterface $innerType, array $typeExtensions = [], ResolvedObjectTypeInterface $parent = null)
    {
        if ('default' !== $innerType->getClass() && !class_exists($innerType->getClass())) {
            throw new InvalidArgumentException(sprintf(
                'The "%s" object default value type class name ("%s") does not exists.',
                \get_class($innerType),
                $innerType->getClass()
            ));
        }

        foreach ($typeExtensions as $extension) {
            if (!$extension instanceof ObjectTypeExtensionInterface) {
                throw new UnexpectedTypeException($extension, 'Fxp\Component\DefaultValue\ObjectTypeExtensionInterface');
            }
        }

        $this->innerType = $innerType;
        $this->typeExtensions = $typeExtensions;
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->innerType->getClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getInnerType()
    {
        return $this->innerType;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeExtensions()
    {
        return $this->typeExtensions;
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder(ObjectFactoryInterface $factory, array $options = [])
    {
        $options = $this->getOptionsResolver()->resolve($options);
        $builder = new ObjectBuilder($factory, $options);
        $builder->setType($this);

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        $data = $this->innerType->newInstance($builder, $options);

        if (null === $data && null !== $this->parent) {
            $data = $this->parent->newInstance($builder, $options);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options): void
    {
        $this->doActionObject('buildObject', $builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options): void
    {
        $this->doActionObject('finishObject', $builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsResolver()
    {
        if (null === $this->optionsResolver) {
            if (null !== $this->parent) {
                $this->optionsResolver = clone $this->parent->getOptionsResolver();
            } else {
                $this->optionsResolver = new OptionsResolver();
            }

            $this->innerType->configureOptions($this->optionsResolver);

            foreach ($this->typeExtensions as $extension) {
                /* @var ObjectTypeExtensionInterface $extension */
                $extension->configureOptions($this->optionsResolver);
            }
        }

        return $this->optionsResolver;
    }

    /**
     * Build or finish the object.
     *
     * @param string                 $method  The buildObject or finishObject method name
     * @param ObjectBuilderInterface $builder
     * @param array                  $options
     */
    protected function doActionObject($method, ObjectBuilderInterface $builder, array $options): void
    {
        if (null !== $this->parent) {
            $this->parent->{$method}($builder, $options);
        }

        $this->innerType->{$method}($builder, $options);

        foreach ($this->typeExtensions as $extension) {
            /* @var ObjectTypeExtensionInterface $extension */
            $extension->{$method}($builder, $options);
        }
    }
}
