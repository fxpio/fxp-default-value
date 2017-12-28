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

use Fxp\Component\DefaultValue\Exception\ExceptionInterface;
use Fxp\Component\DefaultValue\Exception\UnexpectedTypeException;
use Fxp\Component\DefaultValue\Extension\Core\Type\DefaultType;

/**
 * The central registry of the Object Default Value component.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ObjectRegistry implements ObjectRegistryInterface
{
    /**
     * Extensions.
     *
     * @var array An array of ObjectExtensionInterface
     */
    protected $extensions = [];

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @var ResolvedObjectTypeFactoryInterface
     */
    protected $resolvedTypeFactory;

    /**
     * Constructor.
     *
     * @param array                              $extensions          An array of ObjectExtensionInterface
     * @param ResolvedObjectTypeFactoryInterface $resolvedTypeFactory The factory for resolved object default value types
     *
     * @throws UnexpectedTypeException if any extension does not implement ObjectExtensionInterface
     */
    public function __construct(array $extensions, ResolvedObjectTypeFactoryInterface $resolvedTypeFactory)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof ObjectExtensionInterface) {
                throw new UnexpectedTypeException($extension, 'Fxp\Component\DefaultValue\ObjectExtensionInterface');
            }
        }

        $this->extensions = $extensions;
        $this->resolvedTypeFactory = $resolvedTypeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!is_string($name)) {
            throw new UnexpectedTypeException($name, 'string');
        }

        if (!isset($this->types[$name])) {
            /** @var ObjectTypeInterface $type */
            $type = null;

            foreach ($this->extensions as $extension) {
                /* @var ObjectExtensionInterface $extension */
                if ($extension->hasType($name)) {
                    $type = $extension->getType($name);
                    break;
                }
            }

            // fallback to default type
            if (!$type) {
                $type = new DefaultType($name);
            }

            $this->resolveAndAddType($type);
        }

        return $this->types[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        if (isset($this->types[$name])) {
            return true;
        }

        try {
            $this->getType($name);
        } catch (ExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Wraps a type into a ResolvedObjectTypeInterface implementation and connects
     * it with its parent type.
     *
     * @param ObjectTypeInterface $type The type to resolve
     */
    private function resolveAndAddType(ObjectTypeInterface $type)
    {
        $parentType = $type->getParent();
        $typeExtensions = [];

        foreach ($this->extensions as $extension) {
            /* @var ObjectExtensionInterface $extension */
            $typeExtensions = array_merge($typeExtensions,
                $extension->getTypeExtensions('default'),
                $extension->getTypeExtensions($type->getClass())
            );
        }

        $parent = $parentType ? $this->getType($parentType) : null;
        $rType = $this->resolvedTypeFactory->createResolvedType($type, $typeExtensions, $parent);

        $this->types[$type->getClass()] = $rType;
    }
}
