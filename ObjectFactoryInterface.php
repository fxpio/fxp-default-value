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
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface ObjectFactoryInterface
{
    /**
     * Returns a object with the default value.
     *
     * @see create()
     *
     * @param mixed $data    The object instance
     * @param array $options The options
     *
     * @return object The object instance defined by the type
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type or data is not
     *                                           an object
     */
    public function inject($data, array $options = array());

    /**
     * Returns a object with the default value.
     *
     * @see createBuilder()
     *
     * @param string|ObjectTypeInterface $type    The type of the object default value
     * @param object                     $data    The object instance
     * @param array                      $options The options
     *
     * @return object The object instance defined by the type
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type
     */
    public function create($type, $data = null, array $options = array());

    /**
     * Returns a block builder.
     *
     * @param string|ObjectTypeInterface $type    The type of the object default value
     * @param mixed                      $data    The object instance
     * @param array                      $options The options
     *
     * @return ObjectBuilderInterface The object default value builder
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type
     */
    public function createBuilder($type, $data = null, array $options = array());
}
