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

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface ObjectConfigBuilderInterface extends ObjectConfigInterface
{
    /**
     * Set the types.
     *
     * @param ResolvedObjectTypeInterface $type The type of the object default value
     *
     * @return ObjectConfigBuilderInterface
     */
    public function setType(ResolvedObjectTypeInterface $type);

    /**
     * Sets the data of the object default value.
     *
     * @param mixed $data The data of the object default value
     *
     * @return ObjectConfigBuilderInterface
     */
    public function setData($data);

    /**
     * Sets the value for an property.
     *
     * @param string $name  The name of the property
     * @param string $value The value of the property
     *
     * @return ObjectConfigBuilderInterface
     *
     * @throws BadMethodCallException When the data is empty
     */
    public function setProperty($name, $value);

    /**
     * Sets the properties.
     *
     * @param array $properties The properties
     *
     * @return ObjectConfigBuilderInterface
     *
     * @throws BadMethodCallException When the data is empty
     */
    public function setProperties(array $properties);

    /**
     * Builds and returns the object default value configuration.
     *
     * @return ObjectConfigInterface
     */
    public function getObjectConfig();
}
