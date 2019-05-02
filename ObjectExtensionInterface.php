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

/**
 * Interface for extensions which provide types and type extensions.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface ObjectExtensionInterface
{
    /**
     * Returns a type by class name.
     *
     * @param string $classname The class name of the type
     *
     * @throws Exception\InvalidArgumentException if the given type is not supported by this extension
     *
     * @return ObjectTypeInterface The type
     */
    public function getType($classname);

    /**
     * Returns whether the given type is supported.
     *
     * @param string $classname The class name of the type
     *
     * @return bool Whether the type is supported by this extension
     */
    public function hasType($classname);

    /**
     * Returns the extensions for the given type.
     *
     * @param string $classname The class name of the type
     *
     * @return ObjectTypeExtensionInterface[] An array of extensions as ObjectTypeExtensionInterface instances
     */
    public function getTypeExtensions($classname);

    /**
     * Returns whether this extension provides type extensions for the given type.
     *
     * @param string $classname The class name of the type
     *
     * @return bool Whether the given type has extensions
     */
    public function hasTypeExtensions($classname);
}
