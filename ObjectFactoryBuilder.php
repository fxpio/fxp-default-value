<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue;

/**
 * The default implementation of ObjectFactoryBuilderInterface.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFactoryBuilder implements ObjectFactoryBuilderInterface
{
    /**
     * @var ResolvedObjectTypeFactoryInterface
     */
    private $resolvedTypeFactory;

    /**
     * @var array
     */
    private $extensions = array();

    /**
     * @var array
     */
    private $types = array();

    /**
     * @var array
     */
    private $typeExtensions = array();

    /**
     * {@inheritdoc}
     */
    public function setResolvedTypeFactory(ResolvedObjectTypeFactoryInterface $resolvedTypeFactory)
    {
        $this->resolvedTypeFactory = $resolvedTypeFactory;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension(ObjectExtensionInterface $extension)
    {
        $this->extensions[] = $extension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtensions(array $extensions)
    {
        $this->extensions = array_merge($this->extensions, $extensions);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addType(ObjectTypeInterface $type)
    {
        $this->types[$type->getClass()] = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypes(array $types)
    {
        /* @var ObjectTypeInterface $type */
        foreach ($types as $type) {
            $this->types[$type->getClass()] = $type;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeExtension(ObjectTypeExtensionInterface $typeExtension)
    {
        $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypeExtensions(array $typeExtensions)
    {
        /* @var ObjectTypeExtensionInterface $typeExtension */
        foreach ($typeExtensions as $typeExtension) {
            $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectFactory()
    {
        $extensions = $this->extensions;

        if (count($this->types) > 0 || count($this->typeExtensions) > 0) {
            $extensions[] = new PreloadedExtension($this->types, $this->typeExtensions);
        }

        $resolvedTypeFactory = $this->resolvedTypeFactory ?: new ResolvedObjectTypeFactory();
        $registry = new ObjectRegistry($extensions, $resolvedTypeFactory);

        return new ObjectFactory($registry, $resolvedTypeFactory);
    }
}
