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
 * Creates ResolvedObjectTypeInterface instances.
 *
 * This interface allows you to use your custom ResolvedObjectTypeInterface
 * implementation, within which you can customize the concrete ObjectBuilderInterface
 * implementations.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface ResolvedObjectTypeFactoryInterface
{
    /**
     * Resolves a object default value type.
     *
     * @param ObjectTypeInterface              $type
     * @param array                            $typeExtensions
     * @param ResolvedObjectTypeInterface|null $parent
     *
     * @return ResolvedObjectTypeInterface
     *
     * @throws Exception\UnexpectedTypeException  When unexpected type of argument
     * @throws Exception\InvalidArgumentException When the object default value type classname does not exist
     */
    public function createResolvedType(ObjectTypeInterface $type, array $typeExtensions, ResolvedObjectTypeInterface $parent = null);
}
