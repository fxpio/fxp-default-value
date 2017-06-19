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

use Sonatra\Component\DefaultValue\Exception\UnexpectedTypeException;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFactory implements ObjectFactoryInterface
{
    /**
     * @var ObjectRegistryInterface
     */
    protected $registry;

    /**
     * @var ResolvedObjectTypeFactoryInterface
     */
    protected $resolvedTypeFactory;

    /**
     * Construcotr.
     *
     * @param ObjectRegistryInterface            $registry
     * @param ResolvedObjectTypeFactoryInterface $resolvedTypeFactory
     */
    public function __construct(ObjectRegistryInterface $registry, ResolvedObjectTypeFactoryInterface $resolvedTypeFactory)
    {
        $this->registry = $registry;
        $this->resolvedTypeFactory = $resolvedTypeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function inject($data, array $options = array())
    {
        if (!is_object($data)) {
            throw new UnexpectedTypeException(gettype($data), 'object');
        }

        return $this->create(get_class($data), $data, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function create($type, $data = null, array $options = array())
    {
        return $this->createBuilder($type, $data, $options)->getObject();
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder($type, $data = null, array $options = array())
    {
        if ($type instanceof ObjectTypeInterface) {
            $type = $this->resolveType($type);
        } elseif (is_string($type)) {
            $type = $this->registry->getType($type);
        } elseif (!$type instanceof ResolvedObjectTypeInterface) {
            throw new UnexpectedTypeException($type, 'string, Sonatra\Component\DefaultValue\ResolvedObjectTypeInterface or Sonatra\Component\DefaultValue\ObjectTypeInterface');
        }

        $builder = $type->createBuilder($this, $options);

        if (null !== $data) {
            $builder->setData($data);
        }

        return $builder;
    }

    /**
     * Wraps a type into a ResolvedObjectTypeInterface implementation and connects
     * it with its parent type.
     *
     * @param ObjectTypeInterface $type The type to resolve
     *
     * @return ResolvedObjectTypeInterface The resolved type
     */
    private function resolveType(ObjectTypeInterface $type)
    {
        $parentType = $type->getParent();

        if (null !== $parentType) {
            $parentType = $this->registry->getType($parentType);
        }

        return $this->resolvedTypeFactory->createResolvedType($type,
            // Type extensions are not supported for unregistered type instances,
            // i.e. type instances that are passed to the ObjectFactory directly,
            // nor for their parents, if getParent() also returns a type instance.
            array(),
            $parentType
        );
    }
}
